    <tr>
        <td colspan="2"><table style="vertical-align:center;">
            <tr>
            	<td style="width:60px"><?php if($page > 1){?><input type="button" name="firstPage" value="&lt;&lt;" onclick="changePage(<?php echo 1; ?>);"/><input type="button" name="lastPage" value="&lt;" onclick="changePage(<?php echo $page - 1?>);"><?php } ?></td>
                <td>
                	<input style="width:50px" <?php echo ($maxPage<=1?"disabled":"");?> type="text" name="page" value="<?php echo $page; ?>" onkeypress="if(e.keyCode==13)$(statForm).submit();"/>:<?php echo $maxPage; ?>
                	<input type="hidden" name="maxPage" value="<?php echo $maxPage; ?>">
                	<input type="hidden" name="totalRows" value="<?php echo $totalRows; ?>">
                	<input type="hidden" name="queryChanged" value="0">
                </td>
                <?php if($page < $maxPage){?><td><input type="button" name="nextPage" value="&gt;" onclick="changePage(<?php echo $page + 1?>);"/><input type="button" name="lastPage" value="&gt;&gt;" onclick="changePage(<?php echo $maxPage?>)"/></td><?php } ?><td>
            </tr>
        </table></td>
        <td style="vertical-align:middle">Total Rows: <?php echo $totalRows; ?></td>
    </tr>
                    