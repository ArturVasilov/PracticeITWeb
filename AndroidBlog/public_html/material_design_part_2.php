<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Material design</title>
    <link rel="stylesheet" type="text/css" href="articles/material_design/styles.css">
</head>
<body>

<?php
include('pages_header.php');
?>

<p>
    Мы разобрали философию Material Design в общем, но это пока не сильно помогает нам при разработке приложений. Пора
    исправить эту ситуацию и перейти к
    практике.
</p>

<p>
    Понятно, что в ближайшее время лишь малая часть Android-устройств будет работать под управлением версии Android 5.0
    и выше. Поэтому, для того, чтобы
    создать хороший интерфейс в соответствии с Material Design, необходимо использовать библиотеки поддержки, главной из
    которых является appcompat library.
    Эта библиотека позволяет, во-первых, легко использовать единый стиль для всех компонент приложения и делает все
    виджеты «более материальными», и во-вторых,
    улучшает ActionBar.
</p>

<pre style="background:#eee;color:#000">dependencies {
    compile <span style="color:#036a07">'com.android.support:appcompat-v7:22.0.0'</span>
}
</pre>

<p>
    Последние версии Android Studio автоматически добавляют эту библиотеку при создании проекта.
</p>

<p>
    Следующий шаг – определить стили, которое будет использовать наше приложение. Мы уже говорили, что стандартный
    ActionBar необходимо заменить на более
    гибкий Toolbar. Для примера создадим основной стиль приложения. Во-первых, нужно определить цветовую палитру
    приложения, то есть выбрать цвета
    colorPrimary, colorPrimaryDark и colorAccent. Создадим файл colors.xml:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span style="font-weight:700">resources</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">color</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"color_primary"</span>></span><span
        style="color:#06f;font-style:italic">&lt;!-- your color here --></span><span style="color:#1c02ff">&lt;/<span
            style="font-weight:700">color</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">color</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"color_primary_dark"</span>></span><span
        style="color:#06f;font-style:italic">&lt;!-- your color here --></span><span style="color:#1c02ff">&lt;/<span
            style="font-weight:700">color</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">color</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"color_accent"</span>></span><span
        style="color:#06f;font-style:italic">&lt;!-- your color here --></span><span style="color:#1c02ff">&lt;/<span
            style="font-weight:700">color</span>></span>
<span style="color:#1c02ff">&lt;/<span style="font-weight:700">resources</span>></span>
</pre>

<p>
    И создадим главный стиль приложения в файле styles.xml:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span style="font-weight:700">resources</span>></span>
    <span style="color:#06f;font-style:italic">&lt;!-- Base application theme. --></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">style</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"AppTheme"</span>></span>
        <span style="color:#1c02ff">&lt;<span style="font-weight:700">item</span> <span
                style="font-style:italic">name</span>=<span style="color:#036a07">"colorPrimary"</span>></span>@color/color_primary<span
        style="color:#1c02ff">&lt;/<span style="font-weight:700">item</span>></span>
        <span style="color:#1c02ff">&lt;<span style="font-weight:700">item</span> <span
                style="font-style:italic">name</span>=<span style="color:#036a07">"colorPrimaryDark"</span>></span>@color/color_primary_dark<span
        style="color:#1c02ff">&lt;/<span style="font-weight:700">item</span>></span>
        <span style="color:#1c02ff">&lt;<span style="font-weight:700">item</span> <span
                style="font-style:italic">name</span>=<span style="color:#036a07">"colorAccent"</span>></span>@color/color_accent<span
        style="color:#1c02ff">&lt;/<span style="font-weight:700">item</span>></span>
    <span style="color:#1c02ff">&lt;/<span style="font-weight:700">style</span>></span>
<span style="color:#1c02ff">&lt;/<span style="font-weight:700">resources</span>></span>
</pre>

<p>
    Обратите внимание, что перед именами атрибутов нет префикса android, так как мы используем эти имена из библиотеки,
    а не из самой системы Android.
    Следующий же код требует, чтобы параметр minSdkVersion был установлен на 21 – Android 5.0.
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span style="font-weight:700">style</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"AppTheme"</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">item</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"android:colorPrimary"</span>></span>@color/color_primary<span
        style="color:#1c02ff">&lt;/<span style="font-weight:700">item</span>></span>
<span style="color:#1c02ff">&lt;/<span style="font-weight:700">style</span>></span>
</pre>

<p>
    Поскольку Toolbar – это всего лишь обычный виджет, он точно также размещается в xml-файлах и занимает место на
    экране. А это означает, что вначале нам нужно удалить ActionBar. Сделать это можно разными путями, но самый простой
    способ – указать, что наша тема наследуются от различных тем в библиотеке appcompat, которые содержат в названии
    NoActionBar, например, так:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span style="font-weight:700">style</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"AppTheme"</span> <span
            style="font-style:italic">parent</span>=<span
            style="color:#036a07">"Theme.AppCompat.Light.NoActionBar"</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">item</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"colorPrimary"</span>></span>@color/color_primary<span
        style="color:#1c02ff">&lt;/<span style="font-weight:700">item</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">item</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"colorPrimaryDark"</span>></span>@color/color_primary_dark<span
        style="color:#1c02ff">&lt;/<span style="font-weight:700">item</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">item</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"colorAccent"</span>></span>@color/color_accent<span
        style="color:#1c02ff">&lt;/<span style="font-weight:700">item</span>></span>
<span style="color:#1c02ff">&lt;/<span style="font-weight:700">style</span>></span>
</pre>

<p>
    Если сейчас запустить приложение, мы увидим, что ActionBar пропал, но вместо него ничего не появилось. Значит,
    теперь мы можем добавить Toolbar – для этого идем в activity_main.xml и создаем нужную разметку:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span
            style="font-weight:700">RelativeLayout</span> <span style="font-style:italic">xmlns</span>:android=<span
            style="color:#036a07">"http://schemas.android.com/apk/res/android"</span>
                <span style="font-style:italic">xmlns</span>:tools=<span style="color:#036a07">"http://schemas.android.com/tools"</span>
                <span style="font-style:italic">android</span>:layout_width=<span
            style="color:#036a07">"match_parent"</span>
                <span style="font-style:italic">android</span>:layout_height=<span
            style="color:#036a07">"match_parent"</span>
                <span style="font-style:italic">tools</span>:context=<span style="color:#036a07">".MainActivity"</span>></span>

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">android</span>.support.v7.widget.Toolbar
        <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/toolbar"</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span
            style="color:#036a07">"?attr/actionBarSize"</span>
        <span style="font-style:italic">android</span>:gravity=<span style="color:#036a07">"center_vertical|left"</span>
        <span style="font-style:italic">android</span>:background=<span
            style="color:#036a07">"?attr/colorPrimary"</span>/></span>
<span style="color:#1c02ff">&lt;/<span style="font-weight:700">RelativeLayout</span>></span>
</pre>

<p>
    Кроме того, может возникнуть необходимость создать собственный стиль для Toolbar, например, для изменения цвета
    текста. Это можно сделать таким образом:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span style="font-weight:700">style</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"ToolbarStyle"</span> <span
            style="font-style:italic">parent</span>=<span
            style="color:#036a07">"ThemeOverlay.AppCompat.ActionBar"</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">item</span> <span
            style="font-style:italic">name</span>=<span style="color:#036a07">"android:textColorPrimary"</span>></span>#ffffff<span
        style="color:#1c02ff">&lt;/<span style="font-weight:700">item</span>></span>
<span style="color:#1c02ff">&lt;/<span style="font-weight:700">style</span>></span>
</pre>

<p>
    И применим его с помощью атрибута theme у Toolbar. Необходимо учитывать, что этот атрибут находится не в стандартном
    пространстве имен, а в <i>"http://schemas.android.com/apk/res-auto"</i>, поэтому его необходимо объявить заранее:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span style="font-weight:700">android</span>.support.v7.widget.Toolbar
    <span style="font-style:italic">xmlns</span>:app=<span style="color:#036a07">"http://schemas.android.com/apk/res-auto"</span>
    &lt;!-- other attributes --></span>
    app:theme="@style/ToolbarStyle"/>
</pre>

<p>
    Но если теперь запустить приложение, мы увидим только прямоугольник на месте ActionBar, на котором нет ни названия
    нашего приложения, не пунктов меню. Это происходит потому, что Toolbar – обычный виджет, и система не знает, что с
    ним нужно обращаться как с ActionBar, поэтому придется указать это явно с помощью Java-кода.<br><br>

    Перейдем к классу MainActivity. Здесь важно обратить внимание на то, что эта Activity наследуется не от класса
    Activity, а от класса ActionBarActivity, которая в свою очередь наследуется от класса FragmentActivity, которая
    является частью support-v4 library.
    Такая иерархия классов необходима, чтобы обеспечить возможность работы на различных версиях Android и сохранить
    возможность использовать фрагменты. Собственно, все это необходимо из-за достаточно большого процента версии Android
    2.3.3, в которой еще нет фрагментов, поэтому требуется использовать библиотеки поддержки. Однако с учетом
    постоянного уменьшения этого процента, можно ожидать, что эти библиотеки будут переработаны для минимальной версии
    14.<br><br>

    После такого небольшого отступления вернемся к классу MainActivity. Чтобы Toolbar работал по аналогии с ActionBar,
    то есть отображал заголовки, пункты меню и прочее, необходимо использовать метод setSupportActionBar класса
    ActionBarActivity, который принимает на вход Toolbar. Таким образом, мы должны получить ссылку на Toolbar, что
    выполняется стандартным образом и вызвать этот метод. Тогда метод onCreate класса MainActivity будет выглядеть
    следующим образом:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">MainActivity</span> <span
        style="color:#00f;font-weight:700">extends</span> <span style="font-style:italic">ActionBarActivity</span> {

    <span style="color:#00f;font-weight:700">@Override</span>
    <span style="color:#00f;font-weight:700">protected</span> <span style="color:#00f;font-weight:700">void</span> <span
        style="color:#0000a2;font-weight:700">onCreate</span>(<span
        style="color:#00f;font-weight:700">Bundle</span> <span style="font-style:italic">savedInstanceState</span>) {
        <span style="color:#318495">super</span><span style="color:#00f;font-weight:700">.</span>onCreate(savedInstanceState);
        setContentView(<span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>layout<span style="color:#00f;font-weight:700">.</span>activity_main);
        <span style="color:#00f;font-weight:700">Toolbar</span> toolbar <span
        style="color:#00f;font-weight:700">=</span> (<span style="color:#00f;font-weight:700">Toolbar</span>) findViewById(<span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>toolbar);
        setSupportActionBar(toolbar);
    }
}
</pre>

<p>
    Если мы сохраним ссылку на Toolbar, то после мы можем легко выполнять различные действия с ним, например, убирать
    при прокрутке и т.д. В остальном работа с Toolbar – создание пунктов меню, обработка нажатия – аналогичны ActionBar.<br><br>
    Таким образом, мы рассмотрели возможность стилизации Android-приложения с помощью библиотеки appcompat, а также
    виджет Toolbar.
</p>

<hr>

<?php
require_once('CommentsManager.php');
$comments = new CommentsManager();
$comments->printArticleComments(2);
?>

<?php
require_once('SessionManager.php');
echo "<br><br>";
$sessionManager = SessionManager::getInstance();
if ($sessionManager->active()) {
    $name = $sessionManager->getName();
    $link = 'AddComment.php';
    $form = "
        <form id='add_comment' name='add_comment' action={$link} method='post'>
        <input type='text' name='text' id='text' placeholder='Text' required/>
        <input type='hidden' name='article_id' value='2'>
        <input type='hidden' name='article_url' value='material_design_part_2.php'>
        <button type='submit'>Post</button>
    </form>
    ";
    echo $form;
}
else {
    $logIn = "log_in_form.html";
    echo "<a href='" . $logIn . "'>Log in to post comments</a>";
}
?>

</body>
</html>