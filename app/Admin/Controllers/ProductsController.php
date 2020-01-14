<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductsController extends Controller
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
            ->header('Список товаров')
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
            ->header('Изменить товар')
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
            ->header('Создать товар')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->id('ID')->sortable();
        $grid->title('Название');
        $grid->on_sale('В наличии')->display(function ($value) {
            return $value ? 'Да' : 'Нет';
        });
        $grid->price('Цена');
        $grid->rating('Рейтинг');
        $grid->sold_count('Продаж');
        $grid->review_count('Отзывы');

        $grid->actions(function ($actions) {
            $actions->disableView();
//            $actions->disableDelete();
        });
//        $grid->tools(function ($tools) {
//            $tools->batch(function ($batch) {
//                $batch->disableDelete();
//            });
//        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product);

        $form->text('title', 'Название')->rules('required');
        $form->image('image', 'Картинка')->rules('required|image');
        $form->editor('description', 'Описание')->rules('required');
        $form->radio('on_sale', 'Наличие')->options(['1' => 'Да', '0'=> 'Нет'])->default('0');
        $form->hasMany('skus', 'Размер/Вид', function (Form\NestedForm $form) {
            $form->text('title', 'Название')->rules('required');
            $form->text('description', 'Описание')->rules('required');
            $form->text('price', 'Цена')->rules('required|numeric|min:0.01');
            $form->text('stock', 'Оставшийся инвентарь')->rules('required|integer|min:0');
        });

        // Определяем событие обратного вызова, этот обратный вызов будет запущен, когда модель будет сохранена
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });

        return $form;
    }
}
