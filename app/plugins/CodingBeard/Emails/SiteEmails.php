<?php

/**
 * Site Emails
 *
 * @category
 * @package BeardSite
 * @author Tim Marshall <Tim@CodingBeard.com>
 * @copyright (c) 2015, Tim Marshall
 * @license New BSD License
 */

namespace CodingBeard\Emails;

use Phalcon\DI;
use Phalcon\Mvc\User\Component;
use Phalcon\Mvc\View;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class SiteEmails extends Component
{

    /**
     * Render an email template
     * @param string $folder
     * @param string $file
     * @param array $variables
     * @param bool $testView
     * @return object|string
     */
    public function render($folder, $file, $variables, $testView = false)
    {
        $this->view->setViewsDir(__DIR__ . '/templates/');
        $content = $this->view->getRender($folder, $file, $variables);

        $inliner = new CssToInlineStyles();
        $inliner->setCSS(file_get_contents(__DIR__ . '/templates/layouts/style.css'));
        $inliner->setCleanup(true);

        if (stripos($content, '<pre>')) {
            $split = explode('<pre>', $content);

            $inliner->setHTML($split[0]);
            $html = $inliner->convert();

            $result = (object)['html' => $html, 'text' => $split[1]];
        }
        else {
            $inliner->setHTML($content);
            $html = $inliner->convert();

            $newlines = preg_replace('/\s+(\r\n|\r|\n)+/', "\n\n", strip_tags($content, '<a>'));
            $links = preg_replace('~<a.*?href="(https?://[^"]+)".*?>.*?</a>~', '$1', $newlines);
            $text = preg_replace('/[ |\t]+/', " ", $links);

            $result = (object)['html' => $html, 'text' => $text];
        }

        if ($testView) {
            return $result->html . '<pre>' . $result->text . '</pre>';
        }

        return $result;
    }

    /**
     * Queue an email for sending, properties should either be an array containing valid keys and values for the mandrill api
     * and the folder, file, and variable definitions to render the email
     * or an array of arrays for multiple emails being sent
     * @param $properties array
     */
    public function queue($properties)
    {
        if (is_array($properties[0])) {
            foreach ($properties as $email) {
                $this->queue($email);
            }
        }

        if (!is_file(__DIR__ . "/templates/{$properties['folder']}/{$properties['file']}.volt")) {
            throw new \Exception("That view file does not exist.");
        }

        $content = $this->render($properties['folder'], $properties['file'], $properties['variables']);

        $properties['from_email'] .= $this->config->application->domain;
        $properties['html'] = $content->html;
        $properties['text'] = $content->text;

        if (empty($properties['from_name'])) {
            $properties['from_name'] = $this->config->application->name;
        }

        unset($properties['folder'], $properties['file'], $properties['variables']);

        $this->queue->addJob(function ($that) use ($properties) {
            $that->mandrill->messages_send($properties);
        });
    }

}
