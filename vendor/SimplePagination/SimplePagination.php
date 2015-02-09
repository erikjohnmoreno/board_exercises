<?php

class SimplePagination
{
	const MIN_PAGE_NUM = 1;
	const PAGES_TO_ADVANCE = 1;
	const MIN_INDEX_VAL = 0;

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
		$this->prev = max($current - self::MIN_PAGE_NUM, self::MIN_INDEX_VAL);
		$this->next = $current + self::PAGES_TO_ADVANCE;
		$this->start_index = max($this->prev, self::MIN_INDEX_VAL) * $count;

	}
		
	public function checkLastPage(array &$items)
	{
		if (count($items) < $this->count) {
			$this->is_last_page = true;
		} else {
			$this->is_last_page = false;
			array_pop($items);
		}
	}
}

