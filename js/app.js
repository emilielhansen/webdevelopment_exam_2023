// IS EMAIL AVAILABLE
//Checks if the entered email is available during signup.
async function is_email_available(){
  const frm = event.target.form
  const conn = await fetch("/api/api-is-email-available.php", {
    method: "POST",
    body: new FormData(frm)
  })
  if( ! conn.ok ){ 
    console.log("email not available")
    document.querySelector("#msg_email_not_available").classList.remove("hidden")
    return
  }
  console.log("email available")
}

// SIGNUP USER
// Handles user signup and redirects to the login page upon success
async function signup(){
  const frm = event.target
  console.log(frm)
  const conn = await fetch("/api/api-signup.php", {
    method : "POST",
    body : new FormData(frm)
  })

  const data = await conn.text()
  console.log(data) 
 
  if( ! conn.ok ){
    (console.error("Signup failed:", data))
    return
  }

  // Takes the user to the login
  location.href = "http://localhost/views/login.php";
}

// SIGNUP PARTNER
// Handles partner signup and redirects to the partner login page upon success
async function signup_partner(){
  const frm = event.target
  console.log(frm)
  const conn = await fetch("/api/api-signup-partner.php", {
    method : "POST",
    body : new FormData(frm)
  })

  const data = await conn.text()
  console.log(data) 
 
  if( ! conn.ok ){
    (console.error("Signup failed:", data))
    return
  }

  // Takes the user to the logn for partners
  location.href = "http://localhost/views/login.php";
}

// LOGIN USER
// Handles user login and redirects to the user profile page upon success
async function login() {
  const frm = event.target;
  console.log(frm);
  const conn = await fetch("/api/api-login.php", {
    method: "POST",
    body: new FormData(frm)
  });

  const data = await conn.json(); // Parse JSON response

  if (!conn.ok) {
    console.error("Login failed:", data.info);
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = data.info;
    errorMessage.style.display = 'block';

    return;
  }

  // Takes user to the profile page
  location.href = "http://localhost/views/profile.php";
}


// LOGIN PARTNER
// Handles partner login and redirects to the partner profile page upon success
async function login_partner() {
  const frm = event.target;
  console.log(frm);
  const conn = await fetch("/api/api-login-partner.php", {
    method: "POST",
    body: new FormData(frm)
  });

  const data = await conn.json();

  if (!conn.ok) {
    console.error("Login failed:", data.info);
    const errorMessage = document.getElementById('error-message');
    errorMessage.textContent = data.info;
    errorMessage.style.display = 'block';

    return;
  }

  // Takes user to the profile page
  location.href = "http://localhost/views/profile.php";
}

// USER LOGOUT
// Logs out the current user and redirects to the login page.
async function logout_users() {
  const conn = await fetch("/api/api-logout.php", {
    method: "POST",
  });

  const data = await conn.text();
  console.log(data)

  if( ! conn.ok ){
    (console.error("Login failed:", data))
    return
  }

  // Clear session storage
  sessionStorage.clear();

  const cookies = document.cookie.split("; ");
  for (const cookie of cookies) {
    const [name, _] = cookie.split("=");
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/;`;
  }

  // Takes user to the login page
  location.href = "http://localhost/views/login.php"
}


// BLOCK USER
// Toggles the block/unblock status of a user and refreshes the page
async function block_user(event){
  const user_id = event.target.dataset.id
  let is_blocked = event.target.getAttribute("data-is-blocked")

  console.log("user_is_blocked", is_blocked)
  
  const conn = await fetch(
    `/api/api-toggle-user-blocked.php?user_id=${user_id}&is_blocked=${is_blocked}`
  );

  if(is_blocked == 0){
    event.target.innerHTML = "Block"
    event.target.setAttribute("data-is-blocked", 1)
  } else {
    event.target.innerHTML = "Unblock"
    event.target.setAttribute("data-is-blocked", 0)
  }

  const data = await conn.text()
  console.log(data)

  // Refresh the page after block/unblock
  location.reload();
}

// DELETE USER
//Deletes a user, logs them out, and redirects to the login page
async function delete_user(user_id){
  const frm = event.target
  console.log(frm)
  const conn = await fetch(`/api/api-delete-user.php?user_id=${user_id}`)
  const response = await conn.text()
  console.log(response)

  // Logs out the user
  logout_users()
}

// SEARCH USERS FOR ADMIN
// Initiates a search for users and updates the query results
let timer_search_users = ''
function search_users(){
  clearTimeout(timer_search_users)
  timer_search_users = setTimeout(async function(){ 
    const frm = document.querySelector("#frm_search")
    const url = frm.getAttribute('data-url')
    console.log("URL: ", url)
    const conn = await fetch(`/api/${url}`, {
      method : "POST",
      body : new FormData(frm)
    })
    const data = await conn.json()
    document.querySelector("#query_results").innerHTML = ""
    
    data.forEach(user => {
      let div_user = `
        <tr class="bg-neutral-200">
          <td class="px-6 py-4 whitespace-nowrap">${user.user_id}</td>
          <td class="px-6 py-4 whitespace-nowrap">${user.user_name}</td>
          <td class="px-6 py-4 whitespace-nowrap">${user.user_last_name}</td>
          <td class="px-6 py-4 whitespace-nowrap">${user.user_email}</td>
          <td class="px-6 py-4 whitespace-nowrap text-neutral-600">${user.user_is_blocked}</td>
          <td class="px-6 py-4 whitespace-nowrap"></td>
        </tr>
      `
      document.querySelector("#query_results").insertAdjacentHTML('afterbegin', div_user)
    })    
   }, 500)
}

// SEARCH PARTNERS FOR ADMIN
// Initiates a search for partners and updates the query results
let timer_search_partners = ''
function search_partners(){
  clearTimeout(timer_search_partners)
  timer_search_partners = setTimeout(async function(){ 
    const frm = document.querySelector("#frm_search")
    const url = frm.getAttribute('data-url')
    console.log("URL: ", url)
    const conn = await fetch(`/api/${url}`, {
      method : "POST",
      body : new FormData(frm)
    })
    const data = await conn.json()
    document.querySelector("#query_results").innerHTML = ""
    
    data.forEach(user => {
      let div_user = `
      <tr class="bg-neutral-200">
        <td class="px-6 py-4 whitespace-nowrap">${user.user_id}</td>
        <td class="px-6 py-4 whitespace-nowrap">${user.user_name}</td>
        <td class="px-6 py-4 whitespace-nowrap">${user.user_last_name}</td>
        <td class="px-6 py-4 whitespace-nowrap">${user.user_email}</td>
        <td class="px-6 py-4 whitespace-nowrap text-neutral-600">${user.user_is_blocked}</td>
        <td class="px-6 py-4 whitespace-nowrap"></td>
      </tr>
      `
      document.querySelector("#query_results").insertAdjacentHTML('afterbegin', div_user)
    })    
   }, 500)
}

// SEARCH ORDERS 
// Initiates a search for orders and updates the query results
let timer_search_orders = ''
function search_orders(){
  clearTimeout(timer_search_orders)
  timer_search_orders = setTimeout(async function(){ 
    const frm = document.querySelector("#frm_search")
    const url = frm.getAttribute('data-url')
    console.log("URL: ", url)
    const conn = await fetch(`/api/${url}`, {
      method : "POST",
      body : new FormData(frm)
    })
    const data = await conn.json()
    document.querySelector("#query_results").innerHTML = ""
    
    data.forEach(order => {
      let div_order = `
      <tr class="bg-neutral-200">
      <td class="px-6 py-4 whitespace-nowrap">${order.order_id}</td>
      <td class="px-6 py-4 whitespace-nowrap">${order.order_created_at}</td>
      <td class="px-6 py-4 whitespace-nowrap">${order.order_delivered_at ? 'Delivered' : 'Pending'}</td>
      </tr>
      `
      document.querySelector("#query_results").insertAdjacentHTML('afterbegin', div_order)
    })    
   }, 500)
}

// SEARCH EMPLOYEES
// Initiates a search for employees and updates the query results
let timer_search_employees = ''
function search_employees(){
  clearTimeout(timer_search_employees)
  timer_search_employees = setTimeout(async function(){ 
    const frm = document.querySelector("#frm_search")
    const url = frm.getAttribute('data-url')
    console.log("URL: ", url)
    const conn = await fetch(`/api/${url}`, {
      method : "POST",
      body : new FormData(frm)
    })
    const data = await conn.json()
    document.querySelector("#query_results").innerHTML = ""
    
    data.forEach(user => {
      let div_user = `
      <tr class="bg-neutral-200">
        <td class="px-6 py-4 whitespace-nowrap">${user.user_id}</td>
        <td class="px-6 py-4 whitespace-nowrap">${user.user_name}</td>
        <td class="px-6 py-4 whitespace-nowrap">${user.user_last_name}</td>
        <td class="px-6 py-4 whitespace-nowrap">${user.user_email}</td>
        <td class="px-6 py-4 whitespace-nowrap text-neutral-600">${user.user_is_blocked}</td>
        <td class="px-6 py-4 whitespace-nowrap"></td>
      </tr>
      `
      document.querySelector("#query_results").insertAdjacentHTML('afterbegin', div_user)
    })   
   }, 500)
}

// UPDATE NAME
//  Updates user information
async function update_user() {
  const frm = event.target;
  console.log(frm);
  const conn = await fetch("/api/api-update-user.php", {
    method: "POST",
    body: new FormData(frm)
  });

  const data = await conn.text();
  console.log(data)

  if( ! conn.ok ){
    (console.error("Update failed:", data))
    return
  }
}


