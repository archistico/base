<?php

class Article {
    function get($slug) {
        include("views/article.php");
    }
}

class ArticleDelete {
    function get($slug) {
        include("views/articledelete.php");
    }
}