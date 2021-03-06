<!DOCTYPE html>
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" class="ie8"  dir="ltr" lang="ja">
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="ja">
    <!--<![endif]-->
    <head>
        <?php echo $head02 ?>
    </head>
    <body class="wp-admin no-js  post-new-php admin-bar branch-3-3 version-3-3-2 admin-color-fresh">
        <script type="text/javascript">document.body.className = document.body.className.replace('no-js','js');</script>

        <div id="wpwrap">

            <?php echo $adminmenu ?>

            <div id="wpcontent">
                <div id="wpbody">
                    <div id="wpbody-content">

                        <div id="screen-meta" class="metabox-prefs">
                            <?php echo $help ?>
                            <?php echo $screen_option ?>
                        </div>

                        <div id="screen-meta-links">
                            <div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle">
                                <a href="#contextual-help-wrap" id="contextual-help-link" class="show-settings">ヘルプ</a>
                            </div>
                            <div id="screen-options-link-wrap" class="hide-if-no-js screen-meta-toggle">
                                <a href="#screen-options-wrap" id="show-settings-link" class="show-settings">表示オプション</a>
                            </div>
                        </div>

                        <div class="wrap columns-2">
                            <div id="icon-edit" class="icon32 icon32-posts-post"><br /></div>
                            <h2>新規投稿を追加</h2>
                            <?php if ($errors):
                                echo '<div id="message" class="updated">' . "\n";
                                foreach ($errors as $value) {
                                    echo "<strong>エラー</strong>: $value<br />" . "\n";
                                }
                                echo '</div>' . "\n";
                            endif; ?>
                                
                            <?php echo $form_1 ?>
                        </div>

                        <?php echo $form_2 ?>

                        <script type="text/javascript">try{document.post.title.focus();}catch(e){}</script>
                        <div class="clear"></div>

                    </div><!-- wpbody-content -->
                    <div class="clear"></div></div><!-- wpbody -->
                <div class="clear"></div></div><!-- wpcontent -->

            <div id="footer">
                <p id="footer-left" class="alignleft">
                    <span id="footer-thankyou"><a href="http://kohanaframework.org/">kohanaPress</a> のご利用ありがとうございます。</span>
                </p>
                <p id="footer-upgrade" class="alignright">バージョン 3.3.2</p>
                <div class="clear"></div>
            </div>

            <script type='text/javascript'>list_args = {"class":"WP_Post_Comments_List_Table","screen":{"id":"post","base":"post"}};</script>

            <?php echo $wpadminbar ?>

            <link rel='stylesheet' href='/kohana/loadcss?c=1&dir=rtl&AMP;load=wp-jquery-ui-dialog' type='text/css' media='all' />
            <script type='text/javascript' src='/kohana/loadjs?c=1&load=commonl10n,admin-bar,hoverIntent,common,jquery-color,schedule,wp-ajax-response,suggest,wp-lists,jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-sortable,postbox,post,thickbox,media-upload,word-count,editor,quicktags,jquery-ui-resizable,jquery-ui-draggable,jquery-ui-button,jquery-ui-position,jquery-ui-dialog,wpdialogs,wplink,wpdialogs-popup,wp-fullscreen,tinymce-preinit,tinymce,tinymce-options'></script>

            <div style="display:none;">
                <?php echo $form_3 ?>
            </div>

            <?php echo $fullscreen ?>

            <div class="clear"></div>
        </div><!-- wpwrap -->
        <script type="text/javascript">if(typeof wpOnload=='function')wpOnload();</script>
    </body>
</html>
