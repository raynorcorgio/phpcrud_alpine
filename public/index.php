<?php
require_once('../src/session.php');
require_once('../src/data.php');

//if ($_POST) {
//    addPost($_POST['title'], $_POST['content'], getUserId());
//    header('Location: /index.php');
//    exit;
//}

$results = getFullPostData();

?>
<!doctype html>
<html lang="en">
<?php $page_title = "Home";
require('../src/partials/head.php'); ?>

<body>

    <?php if (isUserLoggedIn()) : ?>
        <a href="logout.php">Logout <?php echo getCurrentUser() ?></a>
    <?php else : ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
    <h1>Posts</h1>

    <?php

    //print("<pre>".print_r($results,true)."</pre>");

    ?>
    <div x-data="posting()" x-init="posts = <?php echo htmlspecialchars(json_encode($results), ENT_QUOTES, 'UTF-8', true) ?>">

        <template x-for="post in posts" :key="post.id">
            <article>
                <div style="display: flex; align-items: center; gap: 1em;">

                    <h2 style="margin: unset;" x-text="post.title"></h2>

                    <?php if (isUserLoggedIn()) { ?>
                        <div @click="likePost(post.id)">
                            <svg style="cursor: pointer;" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 50 50">
                                <path d="M 16.375 9 C 10.117188 9 5 14.054688 5 20.28125 C 5 33.050781 19.488281 39.738281 24.375 43.78125 L 25 44.3125 L 25.625 43.78125 C 30.511719 39.738281 45 33.050781 45 20.28125 C 45 14.054688 39.882813 9 33.625 9 C 30.148438 9 27.085938 10.613281 25 13.0625 C 22.914063 10.613281 19.851563 9 16.375 9 Z M 16.375 11 C 19.640625 11 22.480469 12.652344 24.15625 15.15625 L 25 16.40625 L 25.84375 15.15625 C 27.519531 12.652344 30.359375 11 33.625 11 C 38.808594 11 43 15.144531 43 20.28125 C 43 31.179688 30.738281 37.289063 25 41.78125 C 19.261719 37.289063 7 31.179688 7 20.28125 C 7 15.144531 11.1875 11 16.375 11 Z"></path>
                            </svg>
                        </div>
                    <?php } ?>

                    <span x-text="post.likes_count == 0 ? '' : post.likes_count > 1 ? post.likes_count + ' likes' : post.likes_count + ' like' "></span>

                </div>

                <p style="font-weight: 100; font-size: x-small;">
                    <span>By
                        <span x-text="post.username[0].toUpperCase() + post.username.substring(1) "></span> on
                        <!-- https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/DateTimeFormat -->
                        <span x-data="{ date: new Date(post.created_at) }" x-text="new Intl.DateTimeFormat('en-us', { dateStyle: 'full', timeStyle: 'long', timeZone: 'Canada/Pacific' }).format(date)"></span>
                    </span>


                </p>

                <p x-text="post.content"></p>

                <div>
                    <?php if (isAdmin()) { ?>
                        <input type="submit" value="Delete" @click="deletePost(post.id)">
                        <!--                            <form @submit.prevent="deletePost(post.id)">-->
                        <!--                                <input type="hidden" name="id" :value="post.id">-->
                        <!--                                <input type="submit" value="Delete">-->
                        <!--                            </form>-->
                    <?php } ?>
                </div>

                <hr>

            </article>

        </template>

        <?php if (isUserLoggedIn()) { ?>
            <hr x-init="currUserId= <?php echo htmlspecialchars(getUserId()); ?>">
            <h2>Make a Post</h2>
            <form @submit.prevent="submitPost(); form.title = ''; form.content=''">
                <p>
                    <label for="title">Title</label>
                    <input type="text" x-model="form.title" name="title" id="title" required>
                </p>
                <p>
                    <label for="content">Content</label>
                    <textarea x-model="form.content" name="content" id="content" cols="30" rows="10" required></textarea>
                </p>
                <input type="submit" value="Create">
            </form>
        <?php } ?>
    </div>
</body>

</html>