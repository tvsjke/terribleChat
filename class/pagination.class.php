<?php

class Pagination {

    public static function render($current_page, $total_pages) {
        $output = '<ul class="pager">';

        if($current_page == 1) {
            if($total_pages != 1) {
                $output .= '<li><a href="index.php?page='. ++$current_page .'">Вперед</a></li>';
            }
        }
        else if($current_page == $total_pages) {
            $output .= '<li><a href="index.php?page='. --$current_page .'">Назад</a></li>';
        }
        else {
            $output .= '<li><a href="index.php?page='. --$current_page .'">Назад</a></li>';
            $output .= '<li><a href="index.php?page='. ++$current_page .'">Вперед</a></li>';
        }
        $output .='</ul>';
        return $output;
    }
}