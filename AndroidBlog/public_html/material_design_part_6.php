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
    Еще одним крайне интересным из предоставленных Google к выходу Android 5.0 инструментов является класс Palette.
    Material Design кроме всего прочего характеризуется необычными и яркими сочетаниями цветов. Чаще всего эти цвета
    выбираются изначально, еще при создании приложения, и тогда стиль фона, кнопок и прочих элементов приложения всегда
    один и тот же. Однако иногда уместно изменять этот стиль в зависимости от текущего содержания приложения. Например,
    вы отображаете фотографию с морским пляжем с ярким солнцем, а по умолчанию фон вашего приложения и все управляющие
    элементы выдержаны в темном стиле. Такое решение не очень удачно. Для таких ситуаций и создан класс Palette.<br><br>

    Создадим новое приложение. Для использования класса Palette нужно добавить следующую строку в gradle-скрипте:
</p>

<pre style="background:#eee;color:#000">dependencies {
    compile <span style="color:#036a07">'com.android.support:appcompat-v7:22.0.0'</span>
    compile <span style="color:#036a07">'com.android.support:palette-v7:22.0.0'</span>
}
</pre>

<p>
    Создадим простейшую разметку, которая будет состоять из картинки, которую мы будем разбирать на составляющие цвета,
    а также несколько прямоугольников для отображения этих цветов:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span
            style="font-weight:700">LinearLayout</span>
    &lt;!-- ... --></span>
    tools:context=".MainActivity">

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">ImageView</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"wrap_content"</span>
        <span style="font-style:italic">android</span>:layout_gravity=<span
            style="color:#036a07">"center_horizontal"</span>
        <span style="font-style:italic">android</span>:layout_marginTop=<span style="color:#036a07">"8dp"</span>
        <span style="font-style:italic">android</span>:contentDescription=<span
            style="color:#036a07">"@string/image"</span>
        <span style="font-style:italic">android</span>:src=<span style="color:#036a07">"@drawable/image"</span>/></span>

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">LinearLayout</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"wrap_content"</span>
        <span style="font-style:italic">android</span>:orientation=<span
            style="color:#036a07">"horizontal"</span>></span>
        <span style="color:#1c02ff">&lt;<span style="font-weight:700">View</span>
            <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/colorView1"</span>
            <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"0dip"</span>
            <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"@dimen/rectangle_height"</span>
            <span style="font-style:italic">android</span>:layout_weight=<span style="color:#036a07">"1"</span>/></span>
        <span style="color:#06f;font-style:italic">&lt;!-- ... --></span>
    <span style="color:#1c02ff">&lt;/<span style="font-weight:700">LinearLayout</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">LinearLayout</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"wrap_content"</span>
        <span style="font-style:italic">android</span>:layout_marginTop=<span style="color:#036a07">"8dp"</span>
        <span style="font-style:italic">android</span>:orientation=<span
            style="color:#036a07">"horizontal"</span>></span>
        <span style="color:#06f;font-style:italic">&lt;!-- ... --></span>
        <span style="color:#1c02ff">&lt;<span style="font-weight:700">View</span>
            <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/colorView6"</span>
            <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"0dip"</span>
            <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"@dimen/rectangle_height"</span>
            <span style="font-style:italic">android</span>:layout_marginLeft=<span style="color:#036a07">"8dp"</span>
            <span style="font-style:italic">android</span>:layout_weight=<span style="color:#036a07">"1"</span>/></span>
    <span style="color:#1c02ff">&lt;/<span style="font-weight:700">LinearLayout</span>></span>
<span style="color:#1c02ff">&lt;/<span style="font-weight:700">LinearLayout</span>></span>
</pre>

<p>
    В классе MainActivity инициализируем все View и извлечем цвета из изображения:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">MainActivity</span> <span
        style="color:#00f;font-weight:700">extends</span> <span style="font-style:italic">ActionBarActivity</span> {

    <span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">final</span> <span
        style="color:#00f;font-weight:700">View</span>[] mViews <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">View</span>[<span
        style="color:#0000cd">6</span>];

    <span style="color:#00f;font-weight:700">@Override</span>
    <span style="color:#00f;font-weight:700">protected</span> <span style="color:#00f;font-weight:700">void</span> <span
        style="color:#0000a2;font-weight:700">onCreate</span>(<span
        style="color:#00f;font-weight:700">Bundle</span> <span style="font-style:italic">savedInstanceState</span>) {
        <span style="color:#318495">super</span><span style="color:#00f;font-weight:700">.</span>onCreate(savedInstanceState);
        setContentView(<span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>layout<span style="color:#00f;font-weight:700">.</span>activity_main);

        <span style="color:#00f;font-weight:700">int</span>[] ids <span
        style="color:#00f;font-weight:700">=</span> { <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>id<span style="color:#00f;font-weight:700">.</span>colorView1, <span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>colorView2,
                <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>id<span style="color:#00f;font-weight:700">.</span>colorView3, <span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>colorView4,
                <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>id<span style="color:#00f;font-weight:700">.</span>colorView5, <span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>colorView6, };
        <span style="color:#00f;font-weight:700">for</span> (<span style="color:#00f;font-weight:700">int</span> i <span
        style="color:#00f;font-weight:700">=</span> <span style="color:#0000cd">0</span>; i <span
        style="color:#00f;font-weight:700">&lt;</span> ids<span
        style="color:#00f;font-weight:700">.</span>length; i<span style="color:#00f;font-weight:700">++</span>) {
            mViews[i] <span style="color:#00f;font-weight:700">=</span> findViewById(ids[i]);
        }

        extractColors();
    }
}
</pre>

<p>
    Метод extractColors будет выглядеть следующим образом:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">private</span> <span
        style="color:#00f;font-weight:700">void</span> extractColors() {
    <span style="color:#00f;font-weight:700">Bitmap</span> bitmap <span
        style="color:#00f;font-weight:700">=</span> <span style="color:#00f;font-weight:700">BitmapFactory</span><span
        style="color:#00f;font-weight:700">.</span>decodeResource(
            getResources(), <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>drawable<span style="color:#00f;font-weight:700">.</span>image);
    <span style="color:#00f;font-weight:700">Palette</span> palette <span
        style="color:#00f;font-weight:700">=</span> <span style="color:#00f;font-weight:700">Palette</span><span
        style="color:#00f;font-weight:700">.</span>generate(bitmap);
    setColors(palette);
}
</pre>

<p>
    Основным методом, который к тому же является статическим фабричным методом, являются различные версии метода
    generate. Этот метод принимает на вход объект типа Bitmap, то есть картинку, и возвращает объект класса Palette.
    Этот объект содержит все основные цвета переданного изображения, и нам остается только получить их с помощью
    соответствующих методов, что и делает метод setColors:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">private</span> <span
        style="color:#00f;font-weight:700">void</span> setColors(<span style="color:#00f;font-weight:700">Palette</span> palette) {
    <span style="color:#00f;font-weight:700">int</span>[] colors <span style="color:#00f;font-weight:700">=</span> { palette<span
        style="color:#00f;font-weight:700">.</span>getVibrantColor(<span style="color:#00f;font-weight:700">Color</span><span
        style="color:#c5060b;font-weight:700"><span style="color:#00f;font-weight:700">.</span>BLACK</span>),
            palette<span style="color:#00f;font-weight:700">.</span>getLightVibrantColor(<span
        style="color:#00f;font-weight:700">Color</span><span style="color:#c5060b;font-weight:700"><span
            style="color:#00f;font-weight:700">.</span>BLACK</span>),
            palette<span style="color:#00f;font-weight:700">.</span>getDarkVibrantColor(<span
        style="color:#00f;font-weight:700">Color</span><span style="color:#c5060b;font-weight:700"><span
            style="color:#00f;font-weight:700">.</span>BLACK</span>),
            palette<span style="color:#00f;font-weight:700">.</span>getMutedColor(<span
        style="color:#00f;font-weight:700">Color</span><span style="color:#c5060b;font-weight:700"><span
            style="color:#00f;font-weight:700">.</span>BLACK</span>),
            palette<span style="color:#00f;font-weight:700">.</span>getLightMutedColor(<span
        style="color:#00f;font-weight:700">Color</span><span style="color:#c5060b;font-weight:700"><span
            style="color:#00f;font-weight:700">.</span>BLACK</span>),
            palette<span style="color:#00f;font-weight:700">.</span>getDarkMutedColor(<span
        style="color:#00f;font-weight:700">Color</span><span style="color:#c5060b;font-weight:700"><span
            style="color:#00f;font-weight:700">.</span>BLACK</span>), };
    <span style="color:#00f;font-weight:700">for</span> (<span style="color:#00f;font-weight:700">int</span> i <span
        style="color:#00f;font-weight:700">=</span> <span style="color:#0000cd">0</span>; i <span
        style="color:#00f;font-weight:700">&lt;</span> colors<span
        style="color:#00f;font-weight:700">.</span>length; i<span style="color:#00f;font-weight:700">++</span>) {
        mViews[i]<span style="color:#00f;font-weight:700">.</span>setBackgroundColor(colors[i]);
    }
}
</pre>

<p>
    Каждому из этих методов передается значение по умолчанию, которое будет возвращено, если метод generate не смог
    извлечь определенный цвет из изображения.<br><br>

    Очевидно, что анализ изображения с извлечением доминирующих цветом требует достаточно сложных алгоритмов и
    определенного времени работы. Для сложных изображений это может оказаться достаточно трудоемкая задача, поэтому
    кроме метода generate существует еще метод generateAsync, который выполняет задачу в другом потоке и принимает на
    вход интерфейс для обратного вызова. Тогда метод extractColors: можно переписать следующим образом:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">private</span> <span
        style="color:#00f;font-weight:700">void</span> extractColors() {
    <span style="color:#00f;font-weight:700">Bitmap</span> bitmap <span
        style="color:#00f;font-weight:700">=</span> <span style="color:#00f;font-weight:700">BitmapFactory</span><span
        style="color:#00f;font-weight:700">.</span>decodeResource(
            getResources(), <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>drawable<span style="color:#00f;font-weight:700">.</span>image);
    <span style="color:#00f;font-weight:700">Palette</span><span style="color:#00f;font-weight:700">.</span>generateAsync(bitmap,
            <span style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">Palette</span>.<span
        style="color:#00f;font-weight:700">PaletteAsyncListener</span>() {
        <span style="color:#00f;font-weight:700">@Override</span>
        <span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">void</span> <span
        style="color:#0000a2;font-weight:700">onGenerated</span>(<span style="color:#00f;font-weight:700">Palette</span> <span
        style="font-style:italic">palette</span>) {
            setColors(palette);
        }
    });
}
</pre>

<p>
    Теперь мы можем полюбоваться на результат нашей работы:<br><br>

    <img src="articles/material_design/palette.jpg"/><br><br>

    Таким образом, используя класс Palette, мы можем легко адаптировать интерфейс нашего приложения под любое текущее
    содержание.
</p>

<hr>

<?php
require_once('CommentsManager.php');
$comments = new CommentsManager();
$comments->printArticleComments(6);
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
            <input type='hidden' name='article_url' value='material_design_part_6.php'>
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