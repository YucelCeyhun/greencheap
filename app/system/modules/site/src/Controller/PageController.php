<?php

namespace GreenCheap\Site\Controller;

use GreenCheap\Application as App;
use GreenCheap\Site\Model\Page;

class PageController
{
    /**
     * @param int $id
     * @return array
     */
    public static function indexAction($id = 0): array
    {
        if (!$page = Page::find($id)) {
            App::abort(404, __('Page not found.'));
        }

        $page->content = App::content()->applyPlugins($page->content, ['page' => $page, 'markdown' => $page->get('markdown')]);

        return [
            '$view' => [
                'title' => $page->title,
                'name'  => 'system/site/page.php'
            ],
            'page' => $page,
            'node' => App::node()
        ];
    }
}
