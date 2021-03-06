<?php
/**
 * teleport.dev
 * Created: 01.03.16 11:23
 * @copyright Copyright (c) 2016 OSKR NIAEP
 */
use kartik\helpers\Html;

/**
 * @var $this \yii\web\View
 */
$this->title = 'Формы заявок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <div class="panel panel-info">

        <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span></div>

        <div class="panel-body">

            <p>По всем вопросам, проблемам, предложениям касающимся:</p>

            <ul>
                <li>Телефонной связи</li>
                <li>Сотовой связи</li>
                <li>Видеоконференций</li>
                <li>Презентаций</li>
            </ul>

            <p>Вы можете позвонить по телефону <b>00-00</b> или обратится по электронной почте, написав сообщение на
                адрес <a href="mailto:oskr@niaep.ru">oskr@niaep.ru</a></p>

        </div>

    </div>

    <p>Ниже представлены основные формы заявок на телефонную связь.</p>

    <ul>

        <li><?= Html::a('Заявка на номер служебной сотовой связи', ['/docx/mobile-request.docx']) ?></li>
        <br>
        <li><?= Html::a('Заявка на перенос телефона(номера)', ['/docx/Форма заявки на перенос номера.docx']) ?></li>
        <li><?= Html::a('Заявка на смену владельца телефона(номера)', ['/docx/Форма заявки на смену владельца телефона.docx']) ?></li>
        <li><?= Html::a('Заявка на выделение нового телефона', ['/docx/Форма заявки на телефон.docx']) ?></li>
        <br>
        <li><?= Html::a('Заявка инициатора мероприятия с использованием ЦУП', ['/docx/Заявка инициатора мероприятия с использованием ЦУП.xls']) ?></li>
        <li><?= Html::a('Регламент организации мероприятий с использованием помещения ЦУП', 'ftp://aplserver/RLPA2014/Orders/40_120_P_10.02.2014.pdf') ?></li>
        <li><?= Html::a('Регламент организации мероприятий с использованием помещения ЦУП (с изм. Приказ №40/716-П от 02.06.2015)', 'ftp://aplserver/RLPA2015/Orders/40_716_P_02.06.2015.pdf') ?></li>
    </ul>

</div>
