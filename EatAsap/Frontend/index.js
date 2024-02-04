document.addEventListener('DOMContentLoaded', function() {
    let currentIndex = 0;
    const items = document.querySelectorAll('.carousel-item');
    const totalItems = items.length;
  
    function cycleItems() {
      const activeItem = document.querySelector('.carousel-item.active');
      if (activeItem) activeItem.classList.remove('active');
  
      items[currentIndex].classList.add('active');
      currentIndex = (currentIndex + 1) % totalItems; // Loop back to the first item
    }
  
    setInterval(cycleItems, 2000); // Change image every 3 seconds
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.getElementById('hover'); // Corrected method to get the button
    const heroImage = document.querySelector('#hero-image img'); // Correctly target the img element within the hero-image div

    addButton.addEventListener('mouseover', function() {
        heroImage.src = './Assets/peopleTalking.png'; // Ensure the path is correct
    });

    addButton.addEventListener('mouseout', function() {
        heroImage.src = './Assets/longqueue123.png'; // Ensure the path is correct and matches the file extension
    });
});

