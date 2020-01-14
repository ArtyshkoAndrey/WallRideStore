<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Список пользователей')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        // Создайте столбец с именем ID с полем идентификатора пользователя.
        $grid->id('ID');

        // Создайте столбец с именем столбца Имя пользователя с полем имени пользователя. Следующие email () и create_at () одинаковы
        $grid->name('Имя');

        $grid->email('Email');

        $grid->email_verified_at('Подтверждённый')->display(function ($value) {
            return $value ? 'Да' : 'Нет';
        });

        $grid->created_at('Зарегестрировался');

        // Не показывать кнопку «Новый» на странице, потому что нам не нужно создавать новые
        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            // Не показывать кнопку просмотра за каждой строкой
            $actions->disableView();
            // не показывать кнопку удаления после каждой строк
            $actions->disableDelete();
            // не показывать кнопку редактирования после каждой строки
            $actions->disableEdit();
        });

        $grid->tools(function ($tools) {
            // Отключить кнопку массового удаления
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }
}
