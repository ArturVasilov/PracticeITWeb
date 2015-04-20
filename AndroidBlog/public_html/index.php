<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Android Blog</title>
</head>
<body>

<?php
    include('pages_header.php');
?>

<div style="text-decoration: none; display: inline-block; width: 100%;
color: #FFF; background-color: #778899; padding-top: 10px; padding-bottom: 10px;">
    <a href="material_design_part_1.php" title="Material design">
        <div style="font-weight: bold; font-size: large; color: white; width: inherit;">Material design - part 1</div></a>
</div>

<p>
    На ежегодной конференции Google I/O 2014 компания Google предоставила новую концепцию дизайна, которая была
    названа MaterialDesign. Концепция «материального» дизайна была полностью реализована в новой версии Android Lillipop.
</p>

<br><br>

<div style="text-decoration: none; display: inline-block; width: 100%;
color: #FFF; background-color: #778899; padding-top: 10px; padding-bottom: 10px;">
    <a href="material_design_part_2.php" title="Material design">
        <div style="font-weight: bold; font-size: large; color: white; width: inherit;">Material design - part 2</div></a>
</div>

<p>
    Мы разобрали философию Material Design в общем, но это пока не сильно помогает нам при разработке приложений. Пора
    исправить эту ситуацию и перейти к
    практике.
</p>

<br><br>

<div style="text-decoration: none; display: inline-block; width: 100%;
color: #FFF; background-color: #778899; padding-top: 10px; padding-bottom: 10px;">
    <a href="material_design_part_3.php" title="Material design">
        <div style="font-weight: bold; font-size: large; color: white; width: inherit;">Material design - part 3</div></a>
</div>

<p>
    В Android 5.0 было представлено еще три очень интересных виджета – FloatingActionButton, CardView и RecyclerView.
    Первый мы рассмотрели выше, а остальными займемся сейчас. Эти виджеты также можно добавить с помощью библиотек
    поддержки. <br><br>

    Кроме них, мы рассмотрим также виджеты для навигации, которые были добавлены ранее – Navigation drawer,
    SlidingTabLayout + ViewPager. В результате, мы получим представление о том, как можно строить удобный и дружелюбный
    интерфейс пользователя с помощью самых актуальных виджетов. Рассмотрим их по порядку.
</p>

<br><br>

<div style="text-decoration: none; display: inline-block; width: 100%;
color: #FFF; background-color: #778899; padding-top: 10px; padding-bottom: 10px;">
    <a href="material_design_part_4.php" title="Material design">
        <div style="font-weight: bold; font-size: large; color: white; width: inherit;">Material design - part 4</div></a>
</div>

<p>
    Navigation drawer предоставляет возможность удобно перемещаться между отдельными экранами приложения,
    но иногда возникает ситуация, когда в одном экране отображаются элементы, которые слишком сильно связаны между
    собой, чтобы отображать их на отдельных вкладках Navigation drawer, и в то же время, их можно разделить по какому-то
    внутреннему принципу.<br><br>

    Поэтому мы должны рассмотреть еще один паттерн навигации - SlidingTabLayout.
    Кроме того, мы разберем и новый класс для отображения списка элементов - RecyclerView.
</p>

<br><br>

<div style="text-decoration: none; display: inline-block; width: 100%;
color: #FFF; background-color: #778899; padding-top: 10px; padding-bottom: 10px;">
    <a href="material_design_part_5.php" title="Material design">
        <div style="font-weight: bold; font-size: large; color: white; width: inherit;">Material design - part 5</div></a>
</div>

<p>
    Мы остановились на создании адаптера для RecyclerView. Пора продолжить разработку нашего "материального" приложения!
</p>

<br><br>

<div style="text-decoration: none; display: inline-block; width: 100%;
color: #FFF; background-color: #778899; padding-top: 10px; padding-bottom: 10px;">
    <a href="material_design_part_6.php" title="Material design">
        <div style="font-weight: bold; font-size: large; color: white; width: inherit;">Material design - part 6</div></a>
</div>

<p>
    Еще одним крайне интересным из предоставленных Google к выходу Android 5.0 инструментов является класс Palette.
    Material Design кроме всего прочего характеризуется необычными и яркими сочетаниями цветов. Чаще всего эти цвета
    выбираются изначально, еще при создании приложения, и тогда стиль фона, кнопок и прочих элементов приложения всегда
    один и тот же. Однако иногда уместно изменять этот стиль в зависимости от текущего содержания приложения. Например,
    вы отображаете фотографию с морским пляжем с ярким солнцем, а по умолчанию фон вашего приложения и все управляющие
    элементы выдержаны в темном стиле. Такое решение не очень удачно. Для таких ситуаций и создан класс Palette.
</p>

<br><br>

</body>
</html>