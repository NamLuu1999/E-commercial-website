<?php include("header_cart.php"); ?>

    <h1>Your Cart</h1>
    <?php if (empty($_SESSION['cart12']) || count($_SESSION['cart12']) == 0) : ?>
        <p>There are no items in your cart.</p>
    <?php else: ?>
        <form action="." method="post" style="padding-top: 100px">
            <input type="hidden" name="action" value="update">
            <table>
                <tr id="cart_header">
                    <th class="left">Item</th>
                    <th class="right">Item Cost</th>
                    <th class="right">Quantity</th>
                    <th class="right">Item Total</th>
                </tr>
                <?php foreach( $_SESSION['cart12'] as $key => $item ) :
                    $cost  = number_format($item['price'],  2);
                    $total = number_format($item['total'], 2);
                    ?>
                    <tr>
                        <td>
                            <?php echo $item['name']; ?>
                        </td>
                        <td class="right">
                            $<?php echo $cost; ?>
                        </td>
                        <td class="right">
                            <input type="text" class="cart_qty"
                                   name="newqty[<?php echo $key; ?>]"
                                   value="<?php echo $item['qty']; ?>">
                        </td>
                        <td class="right">
                            $<?php echo $total; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr id="cart_footer">
                    <td colspan="3"><b>Subtotal</b></td>
                    <td>$<?php echo number_format(get_subtotal(), 2);; ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="right">
                        <input type="submit" value="Update Cart"/>
                    </td>
                </tr>
            </table>
            <p>Click "Update Cart" to update quantities in your
                cart. Enter a quantity of 0 to remove an item.
            </p>
        </form>
    <?php endif; ?>
    <p><a href=".?action=show_add_item">Add Item</a></p>
    <p><a href=".?action=empty_cart">Empty Cart</a></p>
    <p><a href=".?action=check_out">Check out</a></p>



