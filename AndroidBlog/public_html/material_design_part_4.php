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
    Navigation drawer предоставляет возможность удобно перемещаться между отдельными экранами приложения,
    но иногда возникает ситуация, когда в одном экране отображаются элементы, которые слишком сильно связаны между
    собой, чтобы отображать их на отдельных вкладках Navigation drawer, и в то же время, их можно разделить по какому-то
    внутреннему принципу. Здесь проще привести пример. Допустим, во многих социальных сетях есть друзья, которые
    вынесены в отдельный пункт в боковой панели. Экран друзей может включать в себя показ всех друзей, или только тех,
    кто сейчас в сети, или новые заявки и т.д. Все эти компоненты связаны, их нельзя разделить, но и нельзя отображать
    вместе. Решением этой проблемы является еще один паттерн навигации – SlidingTabLayout, который является крайне
    удобной модификацией вкладок в ActionBar.<br><br>

    Этот паттерн используется во многих приложениях, например, в том же PlayMarket, где он служит для разделения всех
    приложений и установленных на устройстве:<br><br>

    <img src="articles/material_design/tabs.jpg"/><br><br>

    Виджет SlidingTabLayout позволяет составлять один экран из нескольких раздельных элементов, причем между ними можно
    переключаться как с помощью вкладок, так и жестами.<br><br>

    Этого компонента нет как в стандартной библиотеке, так и в репозитории Google. Поэтому придется воспользоваться
    поиском и скачать необходимый проект (нам понадобятся только два файла – SlidingTabLayout.java и
    SlidingTabStrip.java). При этом мы получаем дополнительное преимущество – возможность изменять код этого виджета
    так, как нам нужно. Такая необходимость может возникнуть в случае, если будут меняться стандарты дизайна.<br><br>

    Эти вкладки не являются самостоятельно эффективными. Для обеспечения функционала, описанного выше, нужно
    использовать еще один класс из библиотеки поддержки android-support-v4 ViewPager, который как раз позволяет
    использовать жесты для смены экрана. Принцип работы ViewPager схож с ListView, он также показывает определенную
    разметку в зависимости от текущей вкладки.<br><br>

    Все это без взгляда на приложение может быть непонятным, поэтому перейдем к практике. Создадим новое приложение,
    которое будет являться списком полезных статей, посвященных Android-разработке. Открыв приложение, на главном экране
    мы увидим три вкладки: все статьи, статьи, посвященные Material Design и статьи про новые виджеты. Каждый из экранов
    будет содержать только список статей.<br><br>

    Создадим разметку для Activity. В нее добавим Toolbar и виджеты SlidingTabLayout и ViewPager:
</p>

<pre style="background:#eee;color:#000"><span style="color:#1c02ff">&lt;<span
            style="font-weight:700">LinearLayout</span>
            <span style="font-style:italic">xmlns</span>:android=<span style="color:#036a07">"http://schemas.android.com/apk/res/android"</span>
            <span style="font-style:italic">xmlns</span>:tools=<span style="color:#036a07">"http://schemas.android.com/tools"</span>
            <span style="font-style:italic">android</span>:layout_width=<span
            style="color:#036a07">"match_parent"</span>
            <span style="font-style:italic">android</span>:layout_height=<span
            style="color:#036a07">"match_parent"</span>
            <span style="font-style:italic">android</span>:orientation=<span style="color:#036a07">"vertical"</span>
            <span style="font-style:italic">tools</span>:context=<span
            style="color:#036a07">".MainActivity"</span>></span>

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">include</span> <span
            style="font-style:italic">layout</span>=<span style="color:#036a07">"@layout/toolbar"</span>/></span>

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">ru</span>.guar7387.articlesmanager.slidingtabs.SlidingTabLayout
        <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/sliding_tabs"</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"wrap_content"</span>
        <span style="font-style:italic">android</span>:background=<span
            style="color:#036a07">"?attr/colorPrimary"</span>/></span>

    <span style="color:#1c02ff">&lt;<span style="font-weight:700">android</span>.support.v4.view.ViewPager
        <span style="font-style:italic">android</span>:id=<span style="color:#036a07">"@+id/viewpager"</span>
        <span style="font-style:italic">android</span>:layout_width=<span style="color:#036a07">"match_parent"</span>
        <span style="font-style:italic">android</span>:layout_height=<span style="color:#036a07">"0px"</span>
        <span style="font-style:italic">android</span>:layout_marginTop=<span style="color:#036a07">"@dimen/small_padding"</span>
        <span style="font-style:italic">android</span>:layout_weight=<span style="color:#036a07">"1"</span>
        <span style="font-style:italic">android</span>:background=<span
            style="color:#036a07">"@android:color/white"</span>/></span>

<span style="color:#1c02ff">&lt;/<span style="font-weight:700">LinearLayout</span>></span>
</pre>

<p>
    Теперь нужно создать разметку для элементов ViewPager, которая будет содержать только список и состоять из одного
    элемента RecyclerView. Разметка для файла articles_pager_item.xml:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">&lt;</span><span
        style="color:#00f;font-weight:700">android.support.v7.widget<span style="color:#00f;font-weight:700">.</span>RecyclerView</span>
    xmlns<span style="color:#00f;font-weight:700">:</span>android<span style="color:#00f;font-weight:700">=</span><span
        style="color:#036a07">"http://schemas.android.com/apk/res/android"</span>
    android<span style="color:#00f;font-weight:700">:</span>layout_width<span
        style="color:#00f;font-weight:700">=</span><span style="color:#036a07">"match_parent"</span>
    android<span style="color:#00f;font-weight:700">:</span>layout_height<span
        style="color:#00f;font-weight:700">=</span><span style="color:#036a07">"match_parent"</span>
    android<span style="color:#00f;font-weight:700">:</span>layout_gravity<span
        style="color:#00f;font-weight:700">=</span><span style="color:#036a07">"start"</span>
    android<span style="color:#00f;font-weight:700">:</span>choiceMode<span
        style="color:#00f;font-weight:700">=</span><span style="color:#036a07">"singleChoice"</span>
    android<span style="color:#00f;font-weight:700">:</span>divider<span
        style="color:#00f;font-weight:700">=</span><span style="color:#036a07">"@android:color/transparent"</span>
    android<span style="color:#00f;font-weight:700">:</span>dividerHeight<span
        style="color:#00f;font-weight:700">=</span><span style="color:#036a07">"1dp"</span>
    android<span style="color:#00f;font-weight:700">:</span>orientation<span style="color:#00f;font-weight:700">=</span><span
        style="color:#036a07">"vertical"</span><span style="color:#00f;font-weight:700">/</span><span
        style="color:#00f;font-weight:700">></span>
</pre>

<p>
    И вот здесь мы перешли к еще одному новому виджету – RecyclerView. Это новый класс из библиотеки поддержки,
    подключить который можно следующим образом:
</p>

<pre style="background:#eee;color:#000">dependencies {
    compile <span style="color:#036a07">'com.android.support:appcompat-v7:22.0.0'</span>
    <b>compile <span style="color:#036a07">'com.android.support:recyclerview-v7:22.0.0'</span></b>
}
</pre>

<p>
    RecyclerView имеет несколько принципиальных отличий от ListView. Во-первых, как уже понятно из названия, он
    предназначен для более удобной «утилизации» и переиспользования элементов, то есть то, что делает стандартный
    паттерн ViewHolder. RecyclerView принуждает нас использовать это паттерн при написании адаптера и предоставляет
    удобный интерфейс через переопределение ключевых методов. Во-вторых, он наследуется от класса ViewGroup, а не от
    AbsListView или подобных. Это означает, что теряется легкая работа с индивидуальными элементами. Далее мы
    рассмотрим, какие ограничения это накладывает, и как обойти их.<br><br>

    Небольшое отступление: здесь не приводится код класса Article и ArticleStorage, я лишь скажу, что Article содержит
    строковые поля «тема», «заголовок», «описание» и «ссылка», а ArticleStorage предоставляет необходимый интерфейс для
    работы с набором статей: получение по теме, добавление и прочее.<br><br>

    Создадим адаптер для списка статей:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">ArticlesAdapter</span> <span style="color:#00f;font-weight:700">extends</span>
        <span style="font-style:italic">RecyclerView</span>.<span style="font-style:italic">Adapter&lt;<span
            style="color:#00f;font-weight:700">ArticlesAdapter</span>.</span><span style="font-style:italic">ArticlesHolder</span>> {
}
</pre>

<p>
    Адаптер для RecyclerView должен наследоваться от класса Adapter в классе ListView. Этот класс является обобщенным, а
    в качестве параметра ему необходимо передать класс, который наследуется от класса ViewHolder, который опять-таки
    определен в классе RecyclerView. В этом классе нужно переопределить конструктор и задать все поля, которые
    потребуются для элемента RecyclerView.<br><br>

    В нашем случае элемент списка будет содержать два элемента TextView, которые будут отображать заголовок и краткое
    содержание статьи. Эти виджеты должны инициализироваться в конструкторе. Я сознательно пока не привожу код разметки,
    далее будет понятно, почему.<br><br>

    Как вы заметили, выше я использовать класс ArticlesHolder, определенный в классе ArticlesAdapter. Создадим его:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">static</span> <span style="color:#00f;font-weight:700">class</span> <span
        style="text-decoration:underline">ArticlesHolder</span> <span style="color:#00f;font-weight:700">extends</span> <span
        style="font-style:italic">RecyclerView</span>.<span style="font-style:italic">ViewHolder</span> {

    <span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">final</span> <span
        style="color:#00f;font-weight:700">View</span> view;
    <span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">final</span> <span
        style="color:#00f;font-weight:700">TextView</span> articleTitle;
    <span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">final</span> <span
        style="color:#00f;font-weight:700">TextView</span> articleDescription;

    <span style="color:#00f;font-weight:700">public</span> <span
        style="color:#0000a2;font-weight:700">ArticlesHolder</span>(<span style="color:#00f;font-weight:700">View</span> <span
        style="font-style:italic">itemView</span>) {
        <span style="color:#318495">super</span>(itemView);
        view <span style="color:#00f;font-weight:700">=</span> itemView;
        articleTitle <span style="color:#00f;font-weight:700">=</span> (<span style="color:#00f;font-weight:700">TextView</span>)
                view<span style="color:#00f;font-weight:700">.</span>findViewById(<span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>articleTitleTextView);
        articleDescription <span style="color:#00f;font-weight:700">=</span> (<span style="color:#00f;font-weight:700">TextView</span>)
                view<span style="color:#00f;font-weight:700">.</span>findViewById(<span
        style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>id<span
        style="color:#00f;font-weight:700">.</span>articleDescriptionTextView);
    }
}
</pre>

<p>
    Здесь я сохраняю ссылку на корневой виджет элемента и инициализирую все остальные поля.<br><br>

    Важным моментом является то, что мы можем создавать конструктор с любыми параметрами, на это нет никаких
    ограничений. В классе ArticlesAdapter создадим поле с элементами списка и добавим его в качестве параметра
    конструктора:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">private</span> <span
        style="color:#00f;font-weight:700">final</span> <span style="color:#00f;font-weight:700">List&lt;<span
            style="color:#00f;font-weight:700">Article</span>></span> mArticles;

<span style="color:#00f;font-weight:700">public</span> ArticlesAdapter(<span style="color:#00f;font-weight:700">List&lt;<span
            style="color:#00f;font-weight:700">Article</span>></span> articlesr) {
    <span style="color:#318495">this</span><span style="color:#00f;font-weight:700">.</span>mArticles <span
        style="color:#00f;font-weight:700">=</span> articles;
}
</pre>

<p>
    Класс RecyclerView.Adapter является абстрактным, поэтому нужно реализовать его методы:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">ArticlesHolder</span> onCreateViewHolder(
        <span style="color:#00f;font-weight:700">ViewGroup</span> parent, <span
        style="color:#00f;font-weight:700">int</span> index) {
}
@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">void</span> onBindViewHolder(<span
        style="color:#00f;font-weight:700">ArticlesHolder</span> holder, <span
        style="color:#00f;font-weight:700">int</span> position) {
}

@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">int</span> getItemCount() {
}
</pre>

<p>
    Самым простым является метод getItemCount, который должен просто вернуть количество элементов в списке. Метод
    onCreateViewHolder должен создать элемент View, то есть извлечь его из xml-файла и вернуть ArticlesHolder.
    Конструктор ArticlesHolder как раз принимает на вход элемент View, который служит для отображения конкретного
    элемента списка. В методе onBindViewHolder выполняется установка всех значений (текст, иконки и прочее) для
    компонентов ViewHolder в соответствии со значениями статьи с индексом position. Самое лучшее в таком подходе это то,
    что теперь нет необходимости самому манипулировать элементами View, выбирать, какие создавать, а какие использовать
    заново. RecyclerView инкапсулирует все эти действия, что превращает этот класс в очень мощный и удобный
    инструмент.<br><br>

    Реализуем эти три метода в соответствии с нашими данными.<br><br>

    В методе onCreateViewHolder создаем элемент View из разметки и возвращаем ArticlesHolder:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">ArticlesHolder</span> onCreateViewHolder(
        <span style="color:#00f;font-weight:700">ViewGroup</span> parent, <span
        style="color:#00f;font-weight:700">int</span> index) {
    <span style="color:#00f;font-weight:700">View</span> v <span style="color:#00f;font-weight:700">=</span> <span
        style="color:#00f;font-weight:700">LayoutInflater</span><span style="color:#00f;font-weight:700">.</span>from(parent<span
        style="color:#00f;font-weight:700">.</span>getContext()).
            inflate(<span style="color:#00f;font-weight:700">R</span><span style="color:#00f;font-weight:700">.</span>layout<span
        style="color:#00f;font-weight:700">.</span>articles_list_item, parent, <span
        style="color:#585cf6;font-weight:700">false</span>);
    <span style="color:#00f;font-weight:700">return</span> <span style="color:#00f;font-weight:700">new</span> <span
        style="color:#00f;font-weight:700">ArticlesHolder</span>(v);
}
</pre>

<p>
    В методе onBindViewHolder устанавливаем тексты для заголовка и краткого описания:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">void</span> onBindViewHolder(<span
        style="color:#00f;font-weight:700">ArticlesHolder</span> holder, <span
        style="color:#00f;font-weight:700">int</span> position) {
    <span style="color:#00f;font-weight:700">Article</span> article <span style="color:#00f;font-weight:700">=</span> mArticles<span
        style="color:#00f;font-weight:700">.</span>get(position);
    holder<span style="color:#00f;font-weight:700">.</span>articleTitle<span style="color:#00f;font-weight:700">.</span>setText(article<span
        style="color:#00f;font-weight:700">.</span>getTitle());
    holder<span style="color:#00f;font-weight:700">.</span>articleDescription<span
        style="color:#00f;font-weight:700">.</span>setText(article<span style="color:#00f;font-weight:700">.</span>getDescription());
}
</pre>

<p>
    И вернем количество элементов в методе getItemCount:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">int</span> getItemCount() {
    <span style="color:#00f;font-weight:700">return</span> mArticles<span style="color:#00f;font-weight:700">.</span>size();
}
</pre>

<p>
    Теперь остается самое главное – обработка нажатия на элемент списка. Как я упоминал выше, в RecyclerView нет
    возможности задать обработчик для этого события напрямую, поэтому приходится искать обходные пути.<br><br>

    Один из выходов из такого положения очевиден – присвоить обработчик нажатия элементу view в классе ArticlesHolder
    (собственно, для чего и сохранялась ссылка на этот элемент). Если выполняются простые действия, например, изменение
    параметров элемента списка, то ничего более не требуется. Если же нужно более сложное поведение, например, как в
    нашем случае, открыть ссылку в браузере, это не так просто. Чтобы не прибегать к сильному связыванию (например,
    передать ссылку на activity, и с ее помощью открыть ссылку), можно использовать механизм обратного вызова.<br><br>

    Напомню, что механизм обратного вызова позволяет передать некоторый код (например, ссылку на функцию) или
    возможность вызвать этот код куда-либо, к примеру, в какой-то метод. В Java для механизма обратного вызова чаще
    всего служат интерфейсы и анонимные классы.<br><br>

    В адаптере создадим интерфейс для обратного вызова и поле, которое будет инициализироваться параметром конструктора:
</p>

<pre style="background:#eee;color:#000"><span style="color:#00f;font-weight:700">static</span> <span
        style="color:#00f;font-weight:700">interface</span> <span
        style="text-decoration:underline">ItemClickListener</span> {
    <span style="color:#00f;font-weight:700">void</span> <span
        style="color:#0000a2;font-weight:700">onItemClicked</span>(<span
        style="color:#00f;font-weight:700">Article</span> <span style="font-style:italic">article</span>);
}

<span style="color:#00f;font-weight:700">private</span> <span style="color:#00f;font-weight:700">final</span> <span
        style="color:#00f;font-weight:700">ItemClickListener</span> itemClickListener;

<span style="color:#00f;font-weight:700">public</span> ArticlesAdapter(<span style="color:#00f;font-weight:700">List&lt;<span
            style="color:#00f;font-weight:700">Article</span>></span> articles,
                       <span style="color:#00f;font-weight:700">ItemClickListener</span> itemClickListener) {
    <span style="color:#318495">this</span><span style="color:#00f;font-weight:700">.</span>mArticles <span
        style="color:#00f;font-weight:700">=</span> articles;
    <span style="color:#318495">this</span><span style="color:#00f;font-weight:700">.</span>itemClickListener <span
        style="color:#00f;font-weight:700">=</span> itemClickListener;
}
</pre>

<p>
    Теперь осталось задать обработчик события нажатия для элемента view из класса ViewHolder. Сделать это нужно в методе
    onBindViewHolder:
</p>

<pre style="background:#eee;color:#000">@<span style="color:#00f;font-weight:700">Override</span>
<span style="color:#00f;font-weight:700">public</span> <span style="color:#00f;font-weight:700">void</span> onBindViewHolder(<span
        style="color:#00f;font-weight:700">ArticlesHolder</span> holder, <span
        style="color:#00f;font-weight:700">int</span> position) {
    <span style="color:#00f;font-weight:700">final</span> <span style="color:#00f;font-weight:700">Article</span> article <span
        style="color:#00f;font-weight:700">=</span> mArticles<span style="color:#00f;font-weight:700">.</span>get(position);
    holder<span style="color:#00f;font-weight:700">.</span>view<span style="color:#00f;font-weight:700">.</span>setOnClickListener(<span
        style="color:#00f;font-weight:700">new</span> <span style="color:#00f;font-weight:700">View</span>.<span
        style="color:#00f;font-weight:700">OnClickListener</span>() {
        <span style="color:#00f;font-weight:700">@Override</span>
        <span style="color:#00f;font-weight:700">public</span> <span
        style="color:#00f;font-weight:700">void</span> <span style="color:#0000a2;font-weight:700">onClick</span>(<span
        style="color:#00f;font-weight:700">View</span> <span style="font-style:italic">v</span>) {
            itemClickListener<span style="color:#00f;font-weight:700">.</span>onItemClicked(article);
        }
    });
    <span style="color:#06f;font-style:italic">//...</span>
}
</pre>

<p>
    Теперь наш адаптер готов служить нам.<br><br>

    На этом пора закончить данную статью. В следующей части мы рассмотрим оставшиеся виджеты и то, как использовать
    созданный в этой статье адаптер.
</p>

<hr>

<?php
require_once('CommentsManager.php');
$comments = new CommentsManager();
$comments->printArticleComments(4);
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
        <input type='hidden' name='article_url' value='material_design_part_4.php'>
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