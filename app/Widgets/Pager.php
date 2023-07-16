<?php

namespace App\Widgets;

use App\Components\Widget;

class Pager extends Widget {

    public $totalCount;
    public $pageCount;
    public $perPage;
    public $curPage;

    public function run() {
        list($this->totalCount, $this->perPage, $this->curPage) = [$this->totalCount, $this->perPage, $this->curPage];

        $this->pageCount = ceil($this->totalCount / $this->perPage);

        if ($this->pageCount > 1) {
            $s = '<div class="pager">'
                . ($this->curPage != 0 ? '<div class="pager__nav-button"><a href="?page=1"><</a></div>' : '')
                . '<a href="?page=1" class="pager__thumb ' . ($this->curPage + 1 == 1 ? 'pager__thumb_active' : '') . '">1</a>';

            foreach ($this->paginationPages() as $page) {
                $s .= '<a href="?page=' . $page . '" class="pager__thumb ' . ($this->curPage + 1  == $page ? 'pager__thumb_active' : '') . '">' . $page . '</a>';
            }

            if ($this->curPage <= $this->pageCount && $this->pageCount > 1) {
                $s .= '<a href="?page=' . $this->pageCount . '" class="pager__thumb ' . ($this->curPage + 1 == $this->pageCount ? 'pager__thumb_active' : '') . '">' . $this->pageCount . '</a>';
            }

            return $s . ($this->curPage != $this->pageCount - 1 ? '<div class="pager__nav-button"><a href="?page=' . ($this->curPage + 2) . '">></a></div>' : '') . '</div></div>';
        }

        return '';
    }

    public function paginationPages() {
        $span = 2;
        $pages = [];
        $start = $this->curPage - $span;
        $stop = $this->curPage + $span;
        if ($this->curPage <= $span + 1) {
            $stop += $span * 2 - $this->curPage;
        }
        if ($this->curPage >= $this->pageCount - $span) {
            $start -= $span * 2 - $this->pageCount - 1 + $this->curPage;
        }
        for ($p = $start; $p <= $stop; $p++) {
            if (($p > 1) && ($p < $this->pageCount)) {
                $pages[] = $p;
            }
        }

        return $pages;
    }

}
