<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php if($total_rows > 0): ?>
    <tr class="pagination-container">
        <td colspan="<?php echo $colspan; ?>" class="child-inline-block text-right">
            <span class="margin-right-40">共<span id="total-rows"><?php echo $total_rows; ?></span>条记录</span>
                                    <span class="margin-right-40">
                                        每页<span class="page-size-selector">
                                        <span id="page-size"><?php if ($params['page_size']) {echo $params['page_size'];} else {echo 20;} ?></span>
                                        <span class="caret" aria-hidden="true"></span>
                                        <ul id="page-size-container" class="dropdown-menu" style="display: none;">
                                        </ul>
                                    </span>条记录</span>
                                    </span>
            <ul class="pagination pagination-normal">
                <li>
                    <a id="first-page" href="" aria-label="首页">
                        <span class="glyphicon glyphicon-fast-backward" aria-hidden="true"></span>
                    </a>
                </li>
                <li>
                    <a id="prev-page" href="" aria-label="上一页">
                        <span class="glyphicon glyphicon-step-backward" aria-hidden="true"></span>
                    </a>
                </li>
                <li>
                    <span id="current-page"><?php if ($params['page_index']) {echo +$params['page_index'] + 1;} else {echo 1;} ?></span>
                </li>
                <li>
                    <a id="next-page" href="" aria-label="下一页">
                        <span class="glyphicon glyphicon-step-forward" aria-hidden="true"></span>
                    </a>
                </li>
                <li>
                    <a id="last-page" href="" aria-label="末页">
                        <span class="glyphicon glyphicon-fast-forward" aria-hidden="true"></span>
                    </a>
                </li>
            </ul>
        </td>
    </tr>
    <script>
        $(document).ready(function () {
            var totalRows = $('#total-rows').text();
            var currentPage = + $('#current-page').text();
            var pageSize = $('#page-size').text();
            var totalPage = Math.max(Math.ceil(totalRows / pageSize), 1);
            var pageSizes = [20, 50, 100];
            var pageSizeItems = '', _pageSize, pageSizeSelector = $('.page-size-selector');

            pageSizeSelector.on('click', function () {
                $(this).parents('.pagination-container').find('.dropdown-menu').show();
                setTimeout(function () {
                    $(document).one('click', function () {
                        $('.page-size-selector').parents('.pagination-container').find('.dropdown-menu').hide();
                    });
                }, 0);
            });

            pageSizeSelector.parent().find('.dropdown-menu').on('click', function (e) {
                var $this = $(e.target);

                if (_pageSize != pageSize) {
                    _pageSize = $this.html() || $this.children('page-size').html();
                    refreshQueryPage({'page_size': _pageSize, page_index: 0});
                } else {
                    window.location.reload();
                }
            });

            function getNextPage () {
                if (currentPage < totalPage) {
                    return +currentPage;
                }
                return currentPage - 1;
            }

            function getPrevPage () {
                if (currentPage > 1) {
                    return currentPage - 2;
                }
                return currentPage - 1;
            }

            $('#first-page').attr('href', getQueryString({page_index: 0, page_size: pageSize}));
            $('#last-page').attr('href', getQueryString({page_index: totalPage - 1, page_size: pageSize}));
            $('#prev-page').attr('href', getQueryString({page_index: getPrevPage(), page_size: pageSize}));
            $('#next-page').attr('href', getQueryString({page_index: getNextPage(), page_size: pageSize}));

            for (var i = 0, li = pageSizes.length; i < li; i++) {
                pageSizeItems += '<li><a class="page-size">' + pageSizes[i] + '</a></li>';
            }

            $('#page-size-container').html(pageSizeItems);
        });
    </script>
<?php else: ?>
    <tr class="text-center">
        <td colspan="<?php echo $colspan; ?>">没有数据</td>
    </tr>
<?php endif;?>
