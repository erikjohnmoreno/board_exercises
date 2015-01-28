<?php

class SimplePagination
	{
	public $current; // 現在のページ番号
	public $prev; // ひとつ前のページ番号
	public $next; // ひとつ次のページ番号
	public $count; // 1ページに何件表示するか
	public $start_index; // 何件目から表示するか（1オリジン）
	public $is_last_page; // 最終ページかどうか

	public function __construct($current, $count)
	{
		$this->current = $current;
		$this->count = $count;
		$this->prev = max($current - 1, 0);
		$this->next = $current + 1;
		$this->start_index = ($current - 1) * $count + 1;
	}
	
	public function checkLastPage(array &$items)
	{
		if (count($items) <= $this->count) {
			$this->is_last_page = true;
		} else {
			$this->is_last_page = false;
			array_pop($items);
		}
	}
}

