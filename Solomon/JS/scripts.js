document.addEventListener('DOMContentLoaded', function() {
    let currentIndex = 0;
    const items = document.querySelectorAll('.carousel-item');
    const totalItems = items.length;
  
    function cycleItems() {
      const activeItem = document.querySelector('.carousel-item.active');
      if (activeItem) activeItem.classList.remove('active');
  
      items[currentIndex].classList.add('active');
      currentIndex = (currentIndex + 1) % totalItems; 
    }
  
    setInterval(cycleItems, 2000);
  });
  
  document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.getElementById('hover'); 
    const heroImage = document.querySelector('#hero-image img'); 

    addButton.addEventListener('mouseover', function() {
        heroImage.src = './Assets/peopleTalking.png'; 
    });

    addButton.addEventListener('mouseout', function() {
        heroImage.src = './Assets/longqueue123.png'; 
    });
});

