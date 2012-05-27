<table class="wp-list-table widefat fixed media" cellspacing="0">
    <thead>
        <tr>
            <th scope='col' id='cb' class='manage-column column-cb check-column'  style=""><input type="checkbox" /></th><th scope='col' id='icon' class='manage-column column-icon'  style=""></th><th scope='col' id='title' class='manage-column column-title sortable desc'  style=""><a href="http://localhost/wordpress/wp-admin/upload.php?orderby=title&#038;order=asc"><span>ファイル</span><span class="sorting-indicator"></span></a></th><th scope='col' id='author' class='manage-column column-author sortable desc'  style=""><a href="http://localhost/wordpress/wp-admin/upload.php?orderby=author&#038;order=asc"><span>作成者</span><span class="sorting-indicator"></span></a></th><th scope='col' id='parent' class='manage-column column-parent sortable desc'  style=""><a href="http://localhost/wordpress/wp-admin/upload.php?orderby=parent&#038;order=asc"><span>リンク先:</span><span class="sorting-indicator"></span></a></th><th scope='col' id='comments' class='manage-column column-comments num sortable desc'  style=""><a href="http://localhost/wordpress/wp-admin/upload.php?orderby=comment_count&#038;order=asc"><span><span class="vers"><img alt="コメント" src="http://localhost/wordpress/wp-admin/images/comment-grey-bubble.png" /></span></span><span class="sorting-indicator"></span></a></th><th scope='col' id='date' class='manage-column column-date sortable asc'  style=""><a href="http://localhost/wordpress/wp-admin/upload.php?orderby=date&#038;order=desc"><span>日付</span><span class="sorting-indicator"></span></a></th>	</tr>
    </thead>

    <tfoot>
        <tr>
            <th scope='col'  class='manage-column column-cb check-column'  style="">
                <input type="checkbox" />
            </th>
            <th scope='col'  class='manage-column column-icon'  style=""></th>
            <th scope='col'  class='manage-column column-title sortable desc'  style="">
                <a href="">
                    <span>ファイル</span><span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope='col'  class='manage-column column-author sortable desc'  style="">
                <a href="">
                    <span>作成者</span><span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope='col'  class='manage-column column-parent sortable desc'  style="">
                <a href="">
                    <span>リンク先:</span><span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope='col'  class='manage-column column-comments num sortable desc'  style="">
                <a href="">
                    <span><span class="vers">
                            <img alt="コメント" src="/includes/wp/admin/images/comment-grey-bubble.png" />
                        </span></span>
                    <span class="sorting-indicator"></span>
                </a>
            </th>
            <th scope='col'  class='manage-column column-date sortable asc'  style="">
                <a href="">
                    <span>日付</span><span class="sorting-indicator"></span>
                </a>
            </th>	
        </tr>
    </tfoot>

    <tbody id="the-list">

        <?PHP
        foreach ($data as $d) {
            $id = $d['ID'];
            $post_author = $d['post_author'];
            $user_login = Model::factory('test12_posts')->id2name($post_author);
            $title = HTML::chars($d['title']);
            $description = $d['description'];
            $post_date = $d['post_date'];
            $tn1_name = $d['tn1_name'];
            $tn2_name = $d['tn2_name'];
            $org_name = $d['org_name'];
            $extention = $d['extention'];
            ?>


            <tr id='post-83' class='author-self status-inherit' valign="top">
                <th scope="row" class="check-column">
                    <input type="checkbox" name="media[]" value="83" />
                </th>
                <td class="column-image media-icon">				
                    <a href="<?php echo "/kohana/test12_mediaview?id=" . $id . "&type=tn2&html=1" ?>" target="_blank" title="大きな画像" >
                        <img  src="<?php echo "/kohana/test12_mediaview?id=" . $id . "&type=tn1" ?>" class="attachment-80x60" alt="<?php echo $org_name ?>" title="大きな画像" />				
                    </a>

                </td>
                <td class='title column-title'>
                    <strong><a href="<?php echo "/kohana/test12_mediaview?id=" . $id . "&type=org&html=1" ?>" target="_blank" title="オリジナル画像" ><?php echo $org_name ?></a></strong>
                    <p><?php echo $extention ?></p>
                    <div class="row-actions">
                        <span class='edit'><a href="">編集</a> | </span>
                        <span class='delete'><a class='submitdelete' onclick='return showNotice.warn();' href=''>完全に削除する</a> | </span>
                        <span class='view'><a href="" title="&#8220;自動下書き&#8221; を表示" rel="permalink">表示</a></span>
                    </div>		
                </td>
                <td class='author column-author'><?php echo $user_login ?></td>
                <td class='parent column-parent'>
                    <strong><a href="">メディア</a></strong>
                </td>
                <td class="comments column-comments num">
                    <div class="post-com-count-wrapper">
                        <a href='' title='0件の承認待ち' class='post-com-count'><span class='comment-count'>0</span></a>			
                    </div>
                </td>
                <td class='date column-date'><?php echo $post_date ?></td>
            </tr>


        <?php } ?>
    </tbody>
</table>
<?php
if (!$single) {
    echo '<br />';
    echo '<a href=' . $firstpage . '>&lt;&lt;</a>';
    echo '<a href=' . $beforepage . '>&nbsp;&lt;</a>';
    echo '　前のページ　　　　　次のページ　';
    echo '<a href=' . $nextpage . '>&gt;&nbsp;</a>';
    echo '<a href=' . $lastpage . '>&gt;&gt;</a>';
}
?>



