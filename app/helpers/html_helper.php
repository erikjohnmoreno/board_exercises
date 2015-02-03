<?php
    const SECONDS_PER_MIN = 60;
    const SECONDS_PER_HOUR = 3600;
    const SECONDS_PER_DAY = 86400;
    const SECONDS_PER_MONTH = 2592000;
    const SECONDS_PER_YEAR = 31536000;

function html_encode($string)
{
    if (!isset($string)) return;
    echo htmlspecialchars($string, ENT_QUOTES);
}

function readable_text($s)
{
    $s = htmlspecialchars($s, ENT_QUOTES);
    $s = nl2br($s);
    return $s;
}

function createPaginationLinks($total_rows, $current_page, $max_rows, $extra_params = null)
{
    $total_pages = SimplePagination::MIN_PAGE_NUM;
    if ($total_rows > $max_rows) {
        $total_pages = ceil($total_rows / $max_rows);
    }

    $page_counter = SimplePagination::MIN_PAGE_NUM;
    $page_links = "";

    while ($page_counter <= $total_pages) {
        if ($page_counter == $current_page) {
            $page_links .= "<b><a class='btn btn-default btn-mini disabled'>$current_page</a></b>";
        } else {
            $page_links .= "<a class='btn btn-primary btn-mini' href='?page={$page_counter}&{$extra_params}'>{$page_counter}</a>";
        }
        $page_counter++;
    }
    return $page_links;
}

function getTimeElapsed($created)
{

    $date_created = new DateTime($created);
    $now = new DateTime();
    $time_elapsed = time() - strtotime($created);
    $date_format = $date_created->diff($now);

    if ($time_elapsed < SECONDS_PER_MIN) {
        echo $date_format->format("%s seconds ago");
    } elseif ($time_elapsed > SECONDS_PER_MIN && $time_elapsed < SECONDS_PER_HOUR){
        echo $date_format->format("%i minutes ago");
    } elseif ($time_elapsed >= SECONDS_PER_HOUR && $time_elapsed < SECONDS_PER_DAY) {
        echo $date_format->format("%h hours ago");
    } elseif ($time_elapsed >= SECONDS_PER_DAY && $time_elapsed < SECONDS_PER_MONTH) {
        echo $date_format->format("%d days ago");
    } elseif ($time_elapsed >= SECONDS_PER_MONTH && $time_elapse < SECONDS_PER_YEAR) {
        echo $date_format->format("%m months ago");
    } else {
        echo $date_format->format("%y years ago");
    }
}
