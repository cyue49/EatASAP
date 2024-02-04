// Wait until the DOM is fully loaded before running the code
document.addEventListener('DOMContentLoaded', function() {
  let currentIndex = 0; // Initialize the index for the current carousel item
  const items = document.querySelectorAll('.carousel-item'); // Select all carousel items
  const totalItems = items.length; // Count the total number of carousel items

  // Define a function to cycle through carousel items
  function cycleItems() {
    const activeItem = document.querySelector('.carousel-item.active'); // Find the currently active carousel item
    if (activeItem) activeItem.classList.remove('active'); // Remove the 'active' class if there's an active item

    items[currentIndex].classList.add('active'); // Add 'active' class to the current item
    currentIndex = (currentIndex + 1) % totalItems; // Update the index to the next item, looping back to 0 if at the end
  }

  setInterval(cycleItems, 2000); // Call cycleItems every 2000 milliseconds (2 seconds)
});

// Wait until the DOM is fully loaded before running the second part of the code
document.addEventListener('DOMContentLoaded', function() {
  const addButton = document.getElementById('hover'); // Select the element with the id 'hover'
  const heroImage = document.querySelector('#hero-image'); // Select the img element within the 'hero-image' div

  // Change the hero image source when the mouse hovers over the addButton
  addButton.addEventListener('mouseover', function() {
      heroImage.src = './assets/pictures/peopleTalking.png'; // Set source to 'peopleTalking.png'
  });

  // Revert the hero image source when the mouse stops hovering over addButton
  addButton.addEventListener('mouseout', function() {
      heroImage.src = './assets/pictures/longqueue123.png'; // Set source back to 'longqueue123.png'
  });
});

// Define a function to validate form input before navigation
function validateFormAndNavigate() {
var password = document.getElementById('password').value; // Get the value from the password input
var retypePassword = document.getElementById('retypePassword').value; // Get the value from the retype password input

// Check if the two password inputs match
if (password !== retypePassword) {
  alert('Passwords do not match. Please try again.'); // Show an alert if they don't match
  return false; // Prevent form submission
}

// Redirect to another page if the passwords match
window.location.href = './screens/user/RestaurantProfile.html';
return false; // Prevent default form submission behavior
}
