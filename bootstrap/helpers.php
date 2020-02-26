<?php

function route_class()
{
  return str_replace('.', '-', Route::currentRouteName());
}


function cost($number) {
	return number_format($number, null, null, ' ');
}