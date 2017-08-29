<?php
if (!empty($post->post_password)) {
    if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) return;
}
?>

<?php if ($comments) : ?>

<h3 class="blog-title" id="comments"><?php comments_number('コメントはありません', 'コメント１件', 'コメント%件');?></h3>

<?php foreach ($comments as $comment) : ?>
<div class="commentlist">
<p><?php echo get_avatar( $comment, 50 ); ?>　<?php printf('<cite>%s</cite> | ', get_comment_author_link()); ?>
<?php if ($comment->comment_approved == '0') : ?>
<strong>あなたのコメントは認証待ちです。</strong>
<?php endif; ?>
<?php echo get_comment_time('Y.m.d G:i'); ?><?php edit_comment_link('編集する',' | ',''); ?></p>
<?php comment_text() ?>
</div>
<?php endforeach; ?>

<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>

<div class="comment-head" id="respond">Comment</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p><?php printf('コメントを書くには<a href="%s">ログイン</a>が必要です', get_option('siteurl') . '/wp-login.php?redirect_to=' . urlencode(get_permalink())); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<p style="color:#666">
<?php if ( $user_ID ) : ?>
<?php printf('<a href="%1$s">%2$s</a>としてログインしています', get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="このユーザーからログアウトする">ログアウト &raquo;</a>
<?php else : ?>
<label for="author">Name<?php if ($req) echo '（必須）'; ?></label><br />
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /><br />
<label for="email">E-mail：非公開<?php if ($req) echo '（必須）'; ?></label><br />
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /><br />
<?php endif; ?>
Comment<br />
<textarea name="comment" id="comment" cols="37" rows="10" tabindex="4"></textarea><br />
<img src="<?php echo get_template_directory_uri(); ?>/images/dot.gif" alt="" height="15" width="1"><br />
<input name="submit" type="submit" id="submit" tabindex="5" value="コメントを送信する" /><br />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<?php do_action('comment_form', $post->ID); ?>
</p>
</form>


<?php endif; ?>
<?php endif; ?>
