<?php

namespace App\Admin\Controllers;

use App\Models\CouponCode;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CouponCodesController extends Controller
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
            ->header('Список купонов')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Изменить купон')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Добавить купон')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CouponCode);

        $grid->model()->orderBy('created_at', 'desc');
        $grid->id('ID')->sortable();
        $grid->name('Имя');
        $grid->code('Код');
        $grid->description('Описание');
        $grid->column('usage', 'Сумма')->display(function ($value) {
            return "{$this->used} / {$this->total}";
        });
        $grid->enabled('Активно')->display(function ($value) {
            return $value ? 'Да' : 'Нет';
        });
        $grid->created_at('Время создания')->display(function($value) {
            $value = strtotime($value);
            $value = date("d.m.Y H:i:s", $value);
            return $value;
        });
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CouponCode);

        $form->display('id', 'ID');
        $form->text('name', 'Имя')->rules('required');
        $form->text('code', 'Код')->rules(function($form) {
            // Если $ form-> model () -> id не пусто, это означает редактирование
            if ($id = $form->model()->id) {
                return 'nullable|unique:coupon_codes,code,'.$id.',id';
            } else {
                return 'nullable|unique:coupon_codes';
            }
        });
        $form->radio('type', 'Тип')->options(CouponCode::$typeMap)->rules('required');
        $form->text('value', 'Скидка')->rules(function ($form) {
            if ($form->model()->type === CouponCode::TYPE_PERCENT) {
                // Если выбран тип процентной скидки, диапазон скидок может быть только от 1 до 99
                return 'required|numeric|between:1,99';
            } else {
                // В противном случае, если оно по существу равно 0,01
                return 'required|numeric|min:0.01';
            }
        });
        $form->text('total', 'Кол-во')->rules('required|numeric|min:0');
        $form->text('min_amount', 'Минимальная сумма')->rules('required|numeric|min:0');
        $form->datetime('not_before', 'Время начала');
        $form->datetime('not_after', 'Время окончания');
        $form->radio('enabled', 'Активен')->options(['1' => 'Да', '0' => 'Нет']);

        $form->saving(function (Form $form) {
            if (!$form->code) {
                $form->code = CouponCode::findAvailableCode();
            }
        });

        return $form;
    }
}
