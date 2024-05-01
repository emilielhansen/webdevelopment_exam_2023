<?php
  require_once __DIR__.'/../_.php';
  require_once __DIR__.'/_header.php';

    if (
    !isset($_SESSION['user']['user_role_name']) ||
    ($_SESSION['user']['user_role_name'] !== 'customer' && $_SESSION['user']['user_role_name'] !== 'partner')
    ) {
    if ($_SESSION['user']['user_role_name'] === 'admin') {
        header('Location: profile.php');
    } else {
        header('Location: login.php');
        exit(); // Make sure to exit after sending the header    
    }
}

  $user_id = $_SESSION['user']['user_id'];
  $user_role_name = $_SESSION['user']['user_role_name'];

  $db = _db();

    // Assuming $user_id and $user_role_name are defined earlier in your code
    $q = $db->prepare('SELECT * FROM orders WHERE ' . 
                    ($user_role_name === 'partner' ? 'order_delivered_by_user_fk' : 'order_created_by_user_fk') . 
                    ' = :user_id');

    $q->bindParam(':user_id', $user_id);
    $q->execute(); 
    $orders = $q->fetchAll();
                  
?>

<div class="mt-10 pb-20 m-2 bg-white rounded-md">
    <div class="flex py-4 text-xl">
        <h1 class="text-4xl font-bold mb-2">
            Your Orders
        </h1>
    </div>

    <?php if( !$orders ){ ?>
        <h1>No orders in the system</h1>
        
    <?php }else{?>

        <?php 
            $frm_search_url = 'api-search-orders.php';
        ?>

        <!-- Search form -->
        <form data-url="<?= $frm_search_url ?>" id="frm_search" action="/search-results" method="GET" class="relative flex items-cente ml-auto">
        <input name="query" type="text" class="w-full pl-7 border-4" placeholder="Search Order ID" oninput="search_orders()"
        onfocus="document.querySelector('#query_results').classList.remove('hidden')"
        onfocus="document.querySelector('#show_orders').classList.add('hidden')"
        onkeydown="return event.key != 'Enter';">
        </form>

        <!-- Orders table -->
        <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead>
                <tr>
                        <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">Order ID</th>
                        <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">Created at</th>
                        <th class="px-6 py-3 bg-neutral-800 text-left text-s font-medium text-white tracking-wider">Status</th>
                </tr>
            </thead>

            <!-- Results from search -->
            <tbody id="query_results" class="hidden"></tbody>

            <tbody id="show_orders">
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $order['order_id'] ?></td>

                    <!-- Created at -->
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo $order['order_created_at'] ?></td>

                    <!-- Delivered or pending -->
                    <td class="px-6 py-4 whitespace-nowrap text-neutral-600">
                        <?php echo $order['order_delivered_at'] ? 'Delivered' : 'Pending'; ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
    <?php } ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../js/prevent_enter.js"></script>

<?php
    require_once __DIR__.'/_footer.php';
?>