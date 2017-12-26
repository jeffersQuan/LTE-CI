<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
        </div>
    </div>
</div>
<footer class="main-footer">
    <div class="text-center">
        <span>客服电话:0755-12345678</span>&nbsp;&nbsp;
        <span>客服QQ:12345678</span>&nbsp;&nbsp;
        <span>服务时间:周一到周五09:00-19:00</span>
    </div>
    <div class="text-center">
        Copyright&copy;2013-2018&nbsp;****有限公司&nbsp;All Rights Reserved
    </div>
</footer>
<?php if($has_editor):?>
    <script src="/assets/libs/kindeditor/kindeditor-all-min.js"></script>
    <script>
        var ke = KindEditor.create('#editor', {
            width: '100%',
            height : '700px',
            items: ['undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
                'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
                'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
                'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'hr', 'emoticons', 'pagebreak',
                'anchor', 'link', 'unlink', '|', 'about']
        });
        var keContent;
    </script>
<?php endif;?>
