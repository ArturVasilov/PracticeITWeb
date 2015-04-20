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
    В Android 5.0 было представлено еще три очень интересных виджета – FloatingActionButton, CardView и RecyclerView.
    Первый мы рассмотрели выше, а остальными займемся сейчас. Эти виджеты также можно добавить с помощью библиотек
    поддержки. <br><br>

    Кроме них, мы рассмотрим также виджеты для навигации, которые были добавлены ранее – Navigation drawer,
    SlidingTabLayout + ViewPager. В результате, мы получим представление о том, как можно строить удобный и дружелюбный
    интерфейс пользователя с помощью самых актуальных виджетов. Рассмотрим их по порядку.<br><br>

    Navigation drawer представляет собой боковую панель навигации. Известно, что использовать для навигации в приложении
    меню в ActionBar, является плохим стилем, но такая необходимость часто возникает. Данный виджет решает эту проблему,
    предоставляя пользователю возможность удобно перемещаться между экранами приложения. Этот виджет используется в
    подавляющем большинстве сложных приложений, например, в PlayMarket или Gmail. Боковая панель появляется с помощью
    жеста слева направо (swipe), либо с помощью нажатия на иконку приложения (необходимо реализовать самостоятельно –
    см. ниже).
</p>

<img src="articles/material_design/nav_drawer.jpg">

<p>
    Navigation drawer является частью библиотеки android-support-v4. Но эта библиотека уже включена в состав библиотеки
    appcompat, поэтому дополнительно ничего импортировать не требуется. Для того чтобы добавить Navigation drawer на
    экран, нужно заменить корневой элемент разметки Activity на тэг
    <i>android.support.v4.widget.DrawerLayout</i>. В него необходимо добавить, во-первых, элемент панели – в базовом
    случае
    это просто список ListView, и во-вторых, контейнер для фрагмента. Здесь требуется небольшое пояснение: каждый
    элемента списка навигации обычно служит для перехода на какой-то экран, для чего лучше всего подойдут фрагменты.
    Базовая разметка с боковой панелью навигации будет выглядеть следующим образом:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span style="font-weight:700">android</span>.support.v4.widget.DrawerLayout <span
            style="font-style:italic">xmlns</span>:android=<span style="color:#036a07">"http://schemas.android.com/apk/res/android"</span>
                <span style="font-style:italic">xmlns</span>:tools=<span style="color:#036a07">"http://schemas.android.com/tools"</span>
                <span style="font-style:italic">android</span>:layout_width=<span
            style="color:#036a07">"match_parent"</span>
                <span style="font-style:italic">android</span>:layout_height=<span
            style="color:#036a07">"match_parent"</span>
                <span style="font-style:italic">tools</span>:context=<span style="color:#036a07">".MainActivity"</span>></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">FrameLayout</span>
        <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/content_frame"</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"match_parent"</span>/></span>
    <span style="color:#1c02ff">&lt;<span style="font-weight:700">ListView</span> <span style="font-style:italic">android</span>:id=<span
            style="color:#036a07">"@+id/left_drawer"</span>
              <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"240dp"</span>
              <span style="font-style:italic">android</span>:layout_height=<span
            style="color:#036a07">"match_parent"</span>
              <span style="font-style:italic">android</span>:layout_gravity=<span style="color:#036a07">"start"</span>
              <span style="font-style:italic">android</span>:choiceMode=<span
            style="color:#036a07">"singleChoice"</span>
              <span style="font-style:italic">android</span>:divider=<span style="color:#036a07">"@android:color/transparent"</span>
              <span style="font-style:italic">android</span>:dividerHeight=<span style="color:#036a07">"0dp"</span>
              <span style="font-style:italic">android</span>:background=<span
            style="color:#036a07">"#111"</span>/></span>
<span style="color:#1c02ff">&lt;/<span style="font-weight:700">android</span>.support.v4.widget.DrawerLayout></span>
</pre>

<p>
    Но в данном случае мы должны добавить еще и Toolbar. Здесь возникают небольшие проблемы, так как при добавлении его
    непосредственно в DrawerLayout, он растянется в полную высоту, и могут возникать и другие проблемы. Поэтому
    необходимо обернуть его Navigation Drawer в еще один контейнер и в него добавить Toolbar. Следующий код будет верно
    выполнять эту задачу:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span
            style="font-weight:700">LinearLayout</span>
    <span style="font-style:italic">xmlns</span>:android=<span style="color:#036a07">"http://schemas.android.com/apk/res/android"</span>
    <span style="font-style:italic">xmlns</span>:tools=<span
            style="color:#036a07">"http://schemas.android.com/tools"</span>
    <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
    <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"match_parent"</span>
    <span style="font-style:italic">android</span>:orientation=<span style="color:#036a07">"vertical"</span>
    <span style="font-style:italic">tools</span>:context=<span style="color:#036a07">".MainActivity"</span>></span>

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">include</span> <span
            style="font-style:italic">layout</span>=<span style="color:#036a07">"@layout/toolbar"</span>/></span>

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">android</span>.support.v4.widget.DrawerLayout
        <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/drawer_layout"</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"match_parent"</span>></span>

        <span style="color:#1c02ff">&lt;<span style="font-weight:700">FrameLayout</span>
            <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/content_frame"</span>
            <span style="font-style:italic">android</span>:layout_width=<span
                style="color:#036a07">"match_parent"</span>
            <span style="font-style:italic">android</span>:layout_height=<span
                style="color:#036a07">"match_parent"</span>/></span>

        <span style="color:#1c02ff">&lt;<span style="font-weight:700">ListView</span>
            <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/left_drawer"</span>
            <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"240dp"</span>
            <span style="font-style:italic">android</span>:layout_height=<span
                style="color:#036a07">"match_parent"</span>
            <span style="font-style:italic">android</span>:layout_gravity=<span style="color:#036a07">"start"</span>
            <span style="font-style:italic">android</span>:background=<span
                style="color:#036a07">"@color/color_accent"</span>
            <span style="font-style:italic">android</span>:choiceMode=<span style="color:#036a07">"singleChoice"</span>
            <span style="font-style:italic">android</span>:divider=<span style="color:#036a07">"@android:color/transparent"</span>
            <span style="font-style:italic">android</span>:dividerHeight=<span
                style="color:#036a07">"0dp"</span>/></span>

    <span style="color:#1c02ff">&lt;/<span style="font-weight:700">android</span>.support.v4.widget.DrawerLayout></span>

<span style="color:#1c02ff">&lt;/<span style="font-weight:700">LinearLayout</span>></span>
</pre>

<p>
    <b>Примечание:</b> конструкция вида
    <i>include layout="@layout/toolbar"</i>
    позволяет добавлять в xml-разметку другие файлы. Это может быть выгодно либо в очень больших файлах (уменьшение
    размера путем разбиения на несколько файлов), либо при использовании одной и той же разметки в нескольких экранах
    (простота изменения).
</p>

<p>
    Становится заметно, что Navigation drawer является достаточно сложным элементом в использовании, но это
    компенсируется тем функционалом, который он предоставляет.<br><br>

    Теперь необходимо перейти к MainActivity, в которой инициализировать все виджеты, задать элементы списка для боковой
    панели. Элементы списка задаются стандартным образом с помощью адаптера. Полный код класса MainActivity:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">MainActivity</span> <span
        style="color:#00f;font-weight:700">extends</span> <span style="font-style:italic">ActionBarActivity</span> {

    <span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">Toolbar</span> mToolbar;
    <span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">DrawerLayout</span> mDrawerLayout;
    <span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">ListView</span> mDrawer;

    <span style="color:#00f;font-weight:700">@Override</span>
    <span style="color:#00f;font-weight:700">protected</span> <span style="color:#00f;font-weight:700">void</span> <span
        style="color:#0000a2;font-weight:700">onCreate</span>(<span
        style="color:#00f;font-weight:700">Bundle</span> <span style="font-style:italic">savedInstanceState</span>) {
        <span style="color:#318495">super</span><span style="color:#00f;font-weight:700">.</span>onCreate(savedInstanceState);
        setContentView(<span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>layout<span style="color:#00f;font-weight:700">.</span>activity_main);

        mToolbar <span style="color:#00f;font-weight:700">=</span> (<span
        style="color:#00f;font-weight:700">Toolbar</span>) findViewById(<span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>toolbar);
        setSupportActionBar(mToolbar);

        mDrawerLayout <span style="color:#00f;font-weight:700">=</span> (<span style="color:#00f;font-weight:700">DrawerLayout</span>)
                findViewById(<span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>id<span style="color:#00f;font-weight:700">.</span>drawer_layout);
        mDrawer <span style="color:#00f;font-weight:700">=</span> (<span
        style="color:#00f;font-weight:700">ListView</span>) findViewById(<span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>left_drawer);
        <span style="color:#00f;font-weight:700">String</span>[] drawerItems <span
        style="color:#00f;font-weight:700">=</span> { <span style="color:#036a07">"Item 1"</span>, <span
        style="color:#036a07">"Item 2"</span>, <span style="color:#036a07">"Item 3"</span> };
        mDrawer<span style="color:#00f;font-weight:700">.</span>setAdapter(<span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">ArrayAdapter&lt;></span>(
                <span style="color:#318495">this</span>, <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>layout<span style="color:#00f;font-weight:700">.</span>drawer_item, drawerItems));
    }
}
</pre>

<p>
    <b>Примечание:</b> <i>R.layout.drawer_item</i> не существует, этот xml-файл можно либо реализовать самостоятельно,
    либо
    использовать готовые шаблоны для элементов списка.<br><br>

    На текущем этапе мы можем «вытащить» боковую панель только с помощью жестов. Хорошим тоном считается обеспечение
    такой возможности через иконку приложения. Во-первых, нужно сделать возможным нажатие на иконку приложения:
</p>

<pre style="background:#eee;color:#000">getSupportActionBar()<span style="color:#00f;font-weight:700">.</span>setDisplayHomeAsUpEnabled(<span
        style="color:#585cf6;font-weight:700">true</span>);
getSupportActionBar()<span style="color:#00f;font-weight:700">.</span>setHomeButtonEnabled(<span
        style="color:#585cf6;font-weight:700">true</span>);
</pre>

<p>
    Во-вторых, чтобы отлавливать события открытия / закрытия боковой панели, нужно использовать класс
    ActionBarDrawerToggle, который реализует интерфейс DrawerListener. При открытии и закрытии боковой панели необходимо
    изменять состояние ActionBar, а именно текст заголовка и видимость элементов меню.
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">private</span> <span
        style="color:#00f;font-weight:700">ActionBarDrawerToggle</span> mDrawerToggle;
<span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">CharSequence</span> mDrawerTitle;
<span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">CharSequence</span> mTitle;
<span style="color:#06f;font-style:italic">//...</span>
<span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">final</span> <span
        style="color:#00f;font-weight:700">String</span>[] mDrawerItems <span
        style="color:#00f;font-weight:700">=</span> {<span style="color:#036a07">"Item 1"</span>, <span
        style="color:#036a07">"Item 2"</span>, <span style="color:#036a07">"Item 3"</span>};
</pre>

<p>
    Создадим новый метод createDrawerToggle, в котором инициализируем поле mDrawerToggle и переопределим методы
    обработчиков. Вызовем этот метод в методе onCreate:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">protected</span> <span style="color:#00f;font-weight:700">void</span> onCreate(<span
        style="color:#00f;font-weight:700">Bundle</span> savedInstanceState) {
    <span style="color:#06f;font-style:italic">//...</span>
    mDrawerTitle <span style="color:#00f;font-weight:700">=</span> getTitle();
    mTitle <span style="color:#00f;font-weight:700">=</span> getTitle();
    createToggle();
}

<span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">void</span> createToggle() {
    mDrawerToggle <span style="color:#00f;font-weight:700">=</span> <span style="color:#00f;font-weight:700">new</span> <span
        style="color:#00f;font-weight:700">ActionBarDrawerToggle</span>(<span style="color:#318495">this</span>,
            mDrawerLayout, mToolbar,
            <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>string<span
        style="color:#00f;font-weight:700">.</span>drawer_open, <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>string<span style="color:#00f;font-weight:700">.</span>drawer_close) {
        <span style="color:#00f;font-weight:700">@Override</span>
        <span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">void</span> <span style="color:#0000a2;font-weight:700">onDrawerOpened</span>(<span
        style="color:#00f;font-weight:700">View</span> <span style="font-style:italic">drawerView</span>) {
            <span style="color:#318495">super</span><span style="color:#00f;font-weight:700">.</span>onDrawerOpened(drawerView);
            getSupportActionBar()<span style="color:#00f;font-weight:700">.</span>setTitle(mDrawerTitle);
        }

        <span style="color:#00f;font-weight:700">@Override</span>
        <span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">void</span> <span style="color:#0000a2;font-weight:700">onDrawerClosed</span>(<span
        style="color:#00f;font-weight:700">View</span> <span style="font-style:italic">drawerView</span>) {
            <span style="color:#318495">super</span><span style="color:#00f;font-weight:700">.</span>onDrawerClosed(drawerView);
            getSupportActionBar()<span style="color:#00f;font-weight:700">.</span>setTitle(mTitle);
        }
    };

    mDrawerLayout<span style="color:#00f;font-weight:700">.</span>setDrawerListener(mDrawerToggle);
}
</pre>

<p>
    Мы должны также использовать mDrawerToggle еще в нескольких методах Activity lifecycle, чтобы сохранять правильное
    состояние при изменении конфигурации или выборе пунктов меню:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">protected</span> <span style="color:#00f;font-weight:700">void</span> onPostCreate(<span
        style="color:#00f;font-weight:700">Bundle</span> savedInstanceState) {
    <span style="color:#318495">super</span><span style="color:#00f;font-weight:700">.</span>onPostCreate(savedInstanceState);
    mDrawerToggle<span style="color:#00f;font-weight:700">.</span>syncState();
}
@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">void</span> onConfigurationChanged(<span
        style="color:#00f;font-weight:700">Configuration</span> newConfig) {
    <span style="color:#318495">super</span><span style="color:#00f;font-weight:700">.</span>onConfigurationChanged(newConfig);
    mDrawerToggle<span style="color:#00f;font-weight:700">.</span>onConfigurationChanged(newConfig);
}
@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">boolean</span> onOptionsItemSelected(<span
        style="color:#00f;font-weight:700">MenuItem</span> item) {
    <span style="color:#00f;font-weight:700">if</span> (mDrawerToggle<span style="color:#00f;font-weight:700">.</span>onOptionsItemSelected(item)) {
      <span style="color:#00f;font-weight:700">return</span> <span style="color:#585cf6;font-weight:700">true</span>;
    }
    <span style="color:#00f;font-weight:700">return</span> <span style="color:#318495">super</span><span
        style="color:#00f;font-weight:700">.</span>onOptionsItemSelected(item);
}
</pre>

<p>
    Кроме всего этого, необходимо учитывать ширину боковой панели. Считается хорошим тоном использовать следующие
    правила:
</p>
<ol>
    <li>Ширина боковой панели должна быть не больше 360dp.</li>
    <li>На телефонах ширина боковой панели равна ширине экрана минус высота ActionBar.</li>
    <li>На планшетах боковая панель должна занимать половину экрана.</li>
</ol>
<p>
    Правило 1 является главным и носит обязательный характер.
    Теперь осталось обработать нажатия на элементы списка и показывать нужные экраны. Это достигается тем же образом,
    что и
    с ListView. Вначале для каждого пункта списка создается свой фрагмент, и при выборе пункта, он отображается в
    заранее
    заготовленном контейнере. В данном случае контейнером является FrameLayout с <i>id=content_frame.</i>
    Очевидно, что работа со всеми экранами аналогична, поэтому разберем пример для одного фрагмента. Создадим новый
    класс:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">FirstFragment</span> <span
        style="color:#00f;font-weight:700">extends</span> <span style="font-style:italic">Fragment</span> {

    <span style="color:#00f;font-weight:700">@Nullable</span>
    <span style="color:#00f;font-weight:700">@Override</span>
    <span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">View</span> <span
        style="color:#0000a2;font-weight:700">onCreateView</span>(<span style="color:#00f;font-weight:700">LayoutInflater</span> <span
        style="font-style:italic">inflater</span>,
                             <span style="color:#00f;font-weight:700">ViewGroup</span> <span style="font-style:italic">container</span>,
                             <span style="color:#00f;font-weight:700">Bundle</span> <span style="font-style:italic">savedInstanceState</span>) {
        <span style="color:#00f;font-weight:700">return</span> inflater<span style="color:#00f;font-weight:700">.</span>inflate(<span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>layout<span
        style="color:#00f;font-weight:700">.</span>first_fragment,
                container, <span style="color:#585cf6;font-weight:700">false</span>);
    }
}
</pre>

<p>
    Присвоим списку обработчик события выбора элемента и в нем вызовем новый метод, который изменит фрагмент на
    требуемый (кроме этого, я изменяю заголовок приложения):
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">protected</span> <span style="color:#00f;font-weight:700">void</span> onCreate(<span
        style="color:#00f;font-weight:700">Bundle</span> savedInstanceState) { <span
        style="color:#06f;font-style:italic">//...</span>
    mDrawer <span style="color:#00f;font-weight:700">=</span> (<span style="color:#00f;font-weight:700">ListView</span>) findViewById(<span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>left_drawer);
    mDrawer<span style="color:#00f;font-weight:700">.</span>setAdapter(<span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">ArrayAdapter&lt;></span>(
            <span style="color:#318495">this</span>, <span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>layout<span style="color:#00f;font-weight:700">.</span>drawer_item, mDrawerItems));
    mDrawer<span style="color:#00f;font-weight:700">.</span>setOnItemClickListener(
            <span style="color:#00f;font-weight:700">new</span> <span
        style="color:#00f;font-weight:700">AdapterView</span>.<span style="color:#00f;font-weight:700">OnItemClickListener</span>() {
        <span style="color:#00f;font-weight:700">@Override</span>
        <span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">void</span> <span
        style="color:#0000a2;font-weight:700">onItemClick</span>(<span style="color:#00f;font-weight:700">AdapterView&lt;?></span> <span
        style="font-style:italic">parent</span>,
                                <span style="color:#00f;font-weight:700">View</span> <span style="font-style:italic">view</span>, <span
        style="color:#00f;font-weight:700">int</span> <span style="font-style:italic">position</span>, <span
        style="color:#00f;font-weight:700">long</span> <span style="font-style:italic">id</span>) {
            selectItem(position);
        }
    });
    <span style="color:#06f;font-style:italic">//...</span>
}
</pre>

<p>
    Метод selectItem:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">private</span> <span
        style="color:#00f;font-weight:700">void</span> selectItem(<span style="color:#00f;font-weight:700">int</span> position) {
    mTitle <span style="color:#00f;font-weight:700">=</span> mDrawerItems[position];
    mDrawerLayout<span style="color:#00f;font-weight:700">.</span>closeDrawer(mDrawer);

    <span style="color:#00f;font-weight:700">FragmentTransaction</span> fragmentTransaction <span
        style="color:#00f;font-weight:700">=</span>
            getFragmentManager()<span style="color:#00f;font-weight:700">.</span>beginTransaction();
    <span style="color:#00f;font-weight:700">Fragment</span> fragment <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#585cf6;font-weight:700">null</span>;
    <span style="color:#00f;font-weight:700">switch</span> (position) {
        <span style="color:#00f;font-weight:700">case</span> <span style="color:#0000cd">0</span><span
        style="color:#00f;font-weight:700">:</span>
            fragment <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">FirstFragment</span>();
            <span style="color:#00f;font-weight:700">break</span>;

        <span style="color:#00f;font-weight:700">case</span> <span style="color:#0000cd">1</span><span
        style="color:#00f;font-weight:700">:</span>
            fragment <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">SecondFragment</span>();
            <span style="color:#00f;font-weight:700">break</span>;

        <span style="color:#00f;font-weight:700">case</span> <span style="color:#0000cd">2</span><span
        style="color:#00f;font-weight:700">:</span>
            fragment <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">ThirdFragment</span>();
            <span style="color:#00f;font-weight:700">break</span>;
    }
    fragmentTransaction<span style="color:#00f;font-weight:700">.</span>replace(<span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>content_frame, fragment);
    fragmentTransaction<span style="color:#00f;font-weight:700">.</span>commit();
}
</pre>

<p>
    При перемещении пользователя между экранами через боковую панель, запоминание истории считается неправильным,
    поэтому добавлять фрагменты в стек не требуется.<br><br>

    Так выполняется работа с Navigation drawer - одним из основных компонентов навигации. Этот виджет является удобным
    для пользователя и предоставляет ненавязчивую возможность перемещения между экранами приложения.
</p>

<hr>

<?php
require_once('CommentsManager.php');
$comments = new CommentsManager();
$comments->printArticleComments(3);
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
        <input type='hidden' name='article_id' value='3'>
        <input type='hidden' name='article_url' value='material_design_part_3.php'>
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