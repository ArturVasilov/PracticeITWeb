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
    Мы остановились на создании адаптера для RecyclerView. Пора продолжить разработку нашего "материального" приложения!<br><br>

    Сначала сделаем небольшое отступление и заодно вернемся назад – рассмотрим разметку для элементов списка, а именно
    файл articles_list_item.xml. Я не стал показывать его раньше, чтобы не смешивать материал. В этом файле я
    использовал еще один новый виджет – CardView. Этот виджет представляет собой карточку, которая немного возвышается
    над другими элементами (это достигается с помощью теней) и у которой можно задать закругление краев. Эта карточка
    используется для отображения какой-либо самостоятельной информации. Сейчас очень часто используется подход с
    объединением списков и CardView, но надо учитывать, что карточки в качестве элементов списка можно использовать,
    только если элементы списка являются самостоятельными смысловыми единицами.<br><br>

    Подключить библиотеку с CardView можно следующим образом:
</p>

<pre style="background:#eee;color:#000">dependencies {
    compile <span style="color:#036a07">'com.android.support:appcompat-v7:22.0.0'</span>
    compile <span style="color:#036a07">'com.android.support:recyclerview-v7:22.0.0'</span>
    <b>compile <span style="color:#036a07">'com.android.support:cardview-v7:22.0.0'</span></b>
}
</pre>

<p>
    CardView наследуется от FrameLayout и, следовательно, перенимает ее поведение относительно позиционирования
    элементов.<br><br>

    Перейдем к практике. Файл articles_list_item.xml:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span style="font-weight:700">android</span>.support.v7.widget.CardView
    <span style="font-style:italic">xmlns</span>:android=<span style="color:#036a07">"http://schemas.android.com/apk/res/android"</span>
    <span style="font-style:italic">xmlns</span>:app=<span style="color:#036a07">"http://schemas.android.com/apk/res-auto"</span>
    <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
    <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"match_parent"</span>
    <span style="font-style:italic">android</span>:foreground=<span style="color:#036a07">"?android:attr/selectableItemBackground"</span>
    <span style="font-style:italic">app</span>:cardCornerRadius=<span style="color:#036a07">"3dp"</span>
    <span style="font-style:italic">app</span>:cardElevation=<span style="color:#036a07">"3dp"</span>
    <span style="font-style:italic">app</span>:cardPreventCornerOverlap=<span style="color:#036a07">"true"</span>
    <span style="font-style:italic">app</span>:cardUseCompatPadding=<span style="color:#036a07">"true"</span>></span>

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">LinearLayout</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:orientation=<span style="color:#036a07">"vertical"</span>></span>

        <span style="color:#1c02ff">&lt;<span style="font-weight:700">TextView</span>
            <span style="font-style:italic">android</span>:id=<span
                style="color:#036a07">"@+id/articleTitleTextView"</span>
            <span style="font-style:italic">android</span>:layout_width=<span
                style="color:#036a07">"match_parent"</span>
            <span style="font-style:italic">android</span>:layout_height=<span
                style="color:#036a07">"wrap_content"</span>
            <span style="font-style:italic">android</span>:textSize=<span style="color:#036a07">"24sp"</span>
            <span style="font-style:italic">android</span>:textStyle=<span style="color:#036a07">"bold"</span>/></span>

        <span style="color:#1c02ff">&lt;<span style="font-weight:700">TextView</span>
            <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/articleDescriptionTextView"</span>
            <span style="font-style:italic">android</span>:layout_width=<span
                style="color:#036a07">"match_parent"</span>
            <span style="font-style:italic">android</span>:layout_height=<span
                style="color:#036a07">"wrap_content"</span>
            <span style="font-style:italic">android</span>:textSize=<span style="color:#036a07">"14sp"</span>
            <span style="font-style:italic">android</span>:textStyle=<span
                style="color:#036a07">"italic"</span>/></span>
    <span style="color:#1c02ff">&lt;/<span style="font-weight:700">LinearLayout</span>></span>

<span style="color:#1c02ff">&lt;/<span style="font-weight:700">android</span>.support.v7.widget.CardView></span>
</pre>

<p>
    Разметка достаточно очевидна. Важными являются четыре атрибута CardView, которые находятся в пространстве имен
    app.<br><br>

    Рассмотрим предназначение этих атрибутов:
</p>
<ol>
    <li>cardCornerRadius – закругление углов карточки в dp.</li>
    <li>cardElevation – возвышение карточки относительно родительского объекта. По факту означает размер отбрасываемой
        тени.
    </li>
    <li>cardPreventCornerOverlap и cardUseCompatPadding позволяют сделать очертания карточки более четкими, без этого у
        CardView контуры выделены слабо.
    </li>
</ol>
<p>
    Теперь пора вернуться к нашему приложению и завершить его!<br><br>

    Переходим в MainActivity. Вначале инициализируем Toolbar – это уже стандартная процедура. После извлечем из разметки
    ViewPager и SlidingTabLayout и соединим их с помощью метода setViewPager класса SlidingTabLayout. Тогда код метода
    onCreate будет выглядеть следующим образом:
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

        <span style="color:#00f;font-weight:700">ViewPager</span> viewPager <span
        style="color:#00f;font-weight:700">=</span> (<span style="color:#00f;font-weight:700">ViewPager</span>)
                findViewById(<span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>id<span style="color:#00f;font-weight:700">.</span>viewpager);
        viewPager<span style="color:#00f;font-weight:700">.</span>setAdapter(<span style="color:#00f;font-weight:700">new</span> <span
        style="color:#00f;font-weight:700">PagerAdapter</span>());

        <span style="color:#00f;font-weight:700">SlidingTabLayout</span> mSlidingTabLayout <span
        style="color:#00f;font-weight:700">=</span> (<span style="color:#00f;font-weight:700">SlidingTabLayout</span>)
                findViewById(<span style="color:#00f;font-weight:700">R</span><span
        style="color:#00f;font-weight:700">.</span>id<span style="color:#00f;font-weight:700">.</span>sliding_tabs);

        mSlidingTabLayout<span style="color:#00f;font-weight:700">.</span>setViewPager(viewPager);
    }
<span style="color:#06f;font-style:italic">//...</span>
}
</pre>

<p>
    Единственным непонятным местом остается следующая строка:
</p>

<pre style="background:#eee;color:#000">viewPager<span style="color:#00f;font-weight:700">.</span>setAdapter(<span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">PagerAdapter</span>());
</pre>

<p>
    Я уже упоминал, что принцип работы ViewPager схож с ListView тем, что мы также должны предоставить адаптер, который
    будет предоставлять и манипулировать данными, которые передаются ViewPager для отображения. Этот метод принимает на
    вход класс PagerAdapter, который находится в пакете android.support.v4.view. Но в отличие от ListView, мы должны
    всегда предоставлять собственную реализацию этого адаптера.<br><br>

    Создадим класс PagerAdapter внутри класса MainActivity:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">MainActivity</span> <span
        style="color:#00f;font-weight:700">extends</span> <span style="font-style:italic">ActionBarActivity</span> {
    <span style="color:#06f;font-style:italic">//...</span>
    <span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">PagerAdapter</span> <span style="color:#00f;font-weight:700">extends</span>
            <span style="font-style:italic">android.support.v4.view<span style="color:#00f;font-weight:700">.</span>PagerAdapter</span> {
    }
}
</pre>

<p>
    Этот класс содержит два абстрактных метода, которые нужно реализовать: getCount и isViewFromObject. Название первого
    метода говорит само за себя, второй метод нужен для правильного функционирования адаптера и определяет, связана ли
    эта страница с определенным объектом, который возвращается еще одним методом.<br><br>

    Эти методы просты в реализации (хотя предназначение второго не очевидно):
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">private</span> <span
        style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">PagerAdapter</span> <span style="color:#00f;font-weight:700">extends</span>
        <span style="font-style:italic">android.support.v4.view<span style="color:#00f;font-weight:700">.</span>PagerAdapter</span> {

    <span style="color:#00f;font-weight:700">@Override</span>
    <span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">int</span> <span
        style="color:#0000a2;font-weight:700">getCount</span>() {
        <span style="color:#00f;font-weight:700">return</span> <span style="color:#0000cd">3</span>;
    }

    <span style="color:#00f;font-weight:700">@Override</span>
    <span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">boolean</span> <span
        style="color:#0000a2;font-weight:700">isViewFromObject</span>(<span
        style="color:#00f;font-weight:700">View</span> <span style="font-style:italic">view</span>, <span
        style="color:#00f;font-weight:700">Object</span> <span style="font-style:italic">object</span>) {
        <span style="color:#00f;font-weight:700">return</span> object <span style="color:#00f;font-weight:700">==</span> view;
    }
}
</pre>

<p>
    Обратите внимание, что в методе isViewFromObject проверяется равенство ссылок, то есть на самом деле то, что эти два
    объекта являются одним и тем же объектом.<br><br>

    Но эти два метода играют не ключевую роль в адаптере. Существует еще два метода: instantiateItem и destroyItem. Эти
    методы служат соответственно для создания элемента и его уничтожения. Эти методы не объявлены абстрактными, но их
    реализация выбрасывает исключение UnsupportedOperationException, поэтому для работы адаптера эти методы необходимо
    переопределить.<br><br>

    Начнем с метода уничтожения, так как его реализация намного проще:<br><br>
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">void</span> destroyItem(<span
        style="color:#00f;font-weight:700">ViewGroup</span> container,
                        <span style="color:#00f;font-weight:700">int</span> position, <span
        style="color:#00f;font-weight:700">Object</span> object) {
    container<span style="color:#00f;font-weight:700">.</span>removeView((<span
        style="color:#00f;font-weight:700">View</span>) object);
}
</pre>

<p>
    Здесь мы всего лишь удаляем элемент из контейнера, освобождая место для другого элемента.<br><br>

    В качестве параметра методу создания элемента передается контейнер, в который нужно добавить страницу, а также номер
    вкладки. У нас одинаковый интерфейс для всех вкладок – список статей. Поэтому вначале мы создаем объект
    RecyclerView:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">Object</span> instantiateItem(<span
        style="color:#00f;font-weight:700">ViewGroup</span> container,
                              <span style="color:#00f;font-weight:700">int</span> position) {
    <span style="color:#00f;font-weight:700">RecyclerView</span> recyclerView <span
        style="color:#00f;font-weight:700">=</span>
            (<span style="color:#00f;font-weight:700">RecyclerView</span>) getLayoutInflater()<span
        style="color:#00f;font-weight:700">.</span>inflate
                    (<span style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>layout<span
        style="color:#00f;font-weight:700">.</span>articles_pager_item, container, <span
        style="color:#585cf6;font-weight:700">false</span>);

    <span style="color:#00f;font-weight:700">LinearLayoutManager</span> layoutManager <span
        style="color:#00f;font-weight:700">=</span> <span style="color:#00f;font-weight:700">new</span>
            <span style="color:#00f;font-weight:700">LinearLayoutManager</span>(getApplicationContext());
    layoutManager<span style="color:#00f;font-weight:700">.</span>setOrientation(<span
        style="color:#00f;font-weight:700">LinearLayoutManager</span><span style="color:#c5060b;font-weight:700"><span
            style="color:#00f;font-weight:700">.</span>VERTICAL</span>);
    recyclerView<span style="color:#00f;font-weight:700">.</span>setLayoutManager(layoutManager);
    <span style="color:#06f;font-style:italic">//...</span>
}
</pre>

<p>
    Обратите внимание на последние 3 выражения. Для RecyclerView необходимо задать объект LayoutManager, который будет
    определять его положение, ориентацию и прочее. Без этого, система Android не сможет позиционировать RecyclerView, и
    приложение упадет.<br><br>

    Теперь нам нужно получить список в зависимости от текущей вкладки, создать обработчик события нажатия на элемент
    списка; с помощью этих объектов создать адаптер и присвоить его RecyclerView. После этого мы добавляем RecyclerView
    в контейнер и возвращаем его:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">Object</span> instantiateItem(<span
        style="color:#00f;font-weight:700">ViewGroup</span> container, <span
        style="color:#00f;font-weight:700">int</span> position) {
    <span style="color:#06f;font-style:italic">//... </span>
    <span style="color:#00f;font-weight:700">ArticlesAdapter</span> adapter;
    <span style="color:#00f;font-weight:700">ArticlesAdapter</span><span
        style="color:#00f;font-weight:700">.</span><span style="color:#00f;font-weight:700">ItemClickListener</span> itemClickListener <span
        style="color:#00f;font-weight:700">=</span>
            <span style="color:#00f;font-weight:700">new</span> <span
        style="color:#00f;font-weight:700">ArticlesAdapter</span>.<span style="color:#00f;font-weight:700">ItemClickListener</span>() {
        <span style="color:#00f;font-weight:700">@Override</span>
        <span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">void</span> <span style="color:#0000a2;font-weight:700">onItemClicked</span>(<span
        style="color:#00f;font-weight:700">Article</span> <span style="font-style:italic">article</span>) {
            openUrl(article<span style="color:#00f;font-weight:700">.</span>getUrl());
        }
    };
    <span style="color:#00f;font-weight:700">switch</span> (position) {
        <span style="color:#00f;font-weight:700">case</span> <span style="color:#0000cd">0</span><span
        style="color:#00f;font-weight:700">:</span>
            adapter <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">ArticlesAdapter</span>(
                    <span style="color:#00f;font-weight:700">ArticlesStorage</span><span
        style="color:#c5060b;font-weight:700"><span style="color:#00f;font-weight:700">.</span>INSTANCE</span>.
                            getArticlesByTag(<span style="color:#00f;font-weight:700">Tags</span><span
        style="color:#c5060b;font-weight:700"><span style="color:#00f;font-weight:700">.</span>ALL</span>),
                    itemClickListener);
            <span style="color:#00f;font-weight:700">break</span>;
        <span style="color:#00f;font-weight:700">case</span> <span style="color:#0000cd">1</span><span
        style="color:#00f;font-weight:700">:</span>
            adapter <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">ArticlesAdapter</span>(
                    <span style="color:#00f;font-weight:700">ArticlesStorage</span><span
        style="color:#c5060b;font-weight:700"><span style="color:#00f;font-weight:700">.</span>INSTANCE</span>.
                            getArticlesByTag(<span style="color:#00f;font-weight:700">Tags</span><span
        style="color:#c5060b;font-weight:700"><span style="color:#00f;font-weight:700">.</span>MATERIAL</span>),
                    itemClickListener);
            <span style="color:#00f;font-weight:700">break</span>;

        <span style="color:#00f;font-weight:700">default</span><span style="color:#00f;font-weight:700">:</span>
            adapter <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">ArticlesAdapter</span>(
                    <span style="color:#00f;font-weight:700">ArticlesStorage</span><span
        style="color:#c5060b;font-weight:700"><span style="color:#00f;font-weight:700">.</span>INSTANCE</span>.
                            getArticlesByTag(<span style="color:#00f;font-weight:700">Tags</span><span
        style="color:#c5060b;font-weight:700"><span style="color:#00f;font-weight:700">.</span>WIDGETS</span>),
                    itemClickListener);
            <span style="color:#00f;font-weight:700">break</span>;
    }
    recyclerView<span style="color:#00f;font-weight:700">.</span>setAdapter(adapter);

    container<span style="color:#00f;font-weight:700">.</span>addView(recyclerView);

    <span style="color:#00f;font-weight:700">return</span> recyclerView;
}
</pre>

<p>
    openUrl – это просто метод, который запускает Activity в зависимости от переданной строки, в данном случае это
    браузер:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">private</span> <span
        style="color:#00f;font-weight:700">void</span> openUrl(<span style="color:#00f;font-weight:700">String</span> url) {
    <span style="color:#00f;font-weight:700">Uri</span> uri <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">Uri</span><span style="color:#00f;font-weight:700">.</span>parse(url);
    <span style="color:#00f;font-weight:700">Intent</span> intent <span
        style="color:#00f;font-weight:700">=</span> <span style="color:#00f;font-weight:700">new</span> <span
        style="color:#00f;font-weight:700">Intent</span>(<span style="color:#00f;font-weight:700">Intent</span><span
        style="color:#c5060b;font-weight:700"><span style="color:#00f;font-weight:700">.</span>ACTION_VIEW</span>, uri);
    startActivity(intent);
}
</pre>

<p>
    Итоговое приложение выглядит следующим образом:<br><br>

    <img src="articles/material_design/articles_manager.jpg"/>
</p>

<hr>

<?php
require_once('CommentsManager.php');
$comments = new CommentsManager();
$comments->printArticleComments(5);
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
        <input type='hidden' name='article_url' value='material_design_part_5.php'>
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