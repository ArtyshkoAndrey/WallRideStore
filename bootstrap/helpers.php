<?php


use Illuminate\Database\Eloquent\Collection;

function route_class()
{
  return str_replace('.', '-', Route::currentRouteName());
}


function cost($number) {
	return number_format($number, null, null, ' ');
}

Collection::macro('sortByDate', function ($column = 'created_at', $order = SORT_ASC) {
  /* @var $this Collection */
  return $this->sortBy(function ($datum) use ($column) {
    return strtotime($datum->$column);
  }, SORT_REGULAR, $order == SORT_ASC);
});

