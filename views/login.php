<!-- CUSTOMER/ADMIN LOGIN -->
<?php 
    require_once __DIR__.'/../_.php';
    require_once __DIR__.'/_header.php';  

    if (isset($_SESSION['user'])) {
        // If the user is already logged in, log them out
        session_unset();
        session_destroy();
    }
?>

<div class="max-w-md w-full p-8 shadow-md mx-auto bg-neutral-800 mt-10">
    <form onsubmit="validate(event, login); return false;">
        <h1 class="text-4xl mb-4 text-white">
            Login
        </h1>
        <div class="mb-2">
            <label for="user_email" class="block text-white font-bold">Email</label>
            <input id="user_email" name="user_email" class="border-2 w-full px-3 py-2" type="email" placeholder="Enter email" required>
        </div>

        <div class="mb-2">
            <label for="user_password" class="block text-white font-bold">Password</label>
            <input id="user_password" name="user_password" class="border-2 w-full px-3 py-2" type="password" placeholder="Enter password" required>
        </div>

        <p id="error-message" class="text-red-500 font-bold"></p>
        <button type="submit" class="mt-2 font-bold bg-neutral-200 px-8 py-2">Login</button>
    </form>

    <p class="text-white mt-4">Don't have a user yet?</p>
    <p class="mt-4"><a href="/views/signup.php" class="font-bold text-white">Become a customer</a></p>
    <p><a href="/views/signup_partner.php" class="font-bold text-white">Become a partner</a></p>
</div>

<?php require_once __DIR__.'/_footer.php' ?>

