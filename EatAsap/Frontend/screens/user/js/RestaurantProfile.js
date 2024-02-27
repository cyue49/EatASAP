
const delBtns = document.getElementsByClassName("fa-trash-alt");
const loginBtnTxt = document.getElementById("login").getElementsByTagName("p")[0];
const allEditProfileBtn = document.querySelectorAll("main .retaurant-card .edit-btn");
const formSection = document.getElementById("form-section");
const form = document.getElementById("form");
const submitBtn = document.getElementById("submit-btn");
const log = document.getElementById("login");
//debugger;
document.addEventListener('DOMContentLoaded', function () {
    restaurantinformation()
    addMenuItems();
    
    //delete events
    const allDelBtn = document.querySelectorAll("main .card .del-btn");
    for (let btn of allDelBtn) {
            btn.addEventListener("click", delCard);
        }
    //debugger;    
    //edit Profile events
    for (let epbtn of allEditProfileBtn) {
        epbtn.addEventListener("click", function() {
            window.location.href = '../user/restaurantInformation.html';
        });
    }

    //edit item event
    const allEditItemBtn = document.querySelectorAll("main .card .edit-btn");
    for (let eibtn of allEditItemBtn) {
        eibtn.addEventListener("click", editCard);
        
    }
    
});

document.addEventListener('DOMContentLoaded', function () {

    // for testing purposes user is logged in by default
    login(true);

    log.addEventListener('click', function () {

        const currentStatus = localStorage.getItem('signedIn') === 'true';
        localStorage.setItem('signedIn', String(!currentStatus));
        login(!currentStatus);

    });
});

form.addEventListener("submit", addCard);

document.addEventListener('DOMContentLoaded', popUpAddItem);

function popUpAddItem() {
    var addButton = document.getElementById('add-btn');
    var overlay = document.querySelector('.overlay');
    var overlayBg = document.querySelector('.overlay-bg');

    addButton.addEventListener('click', function () {
        overlay.style.display = 'flex';
        overlayBg.style.display = 'flex';
    });

    // close the pop-up window
    var closeButton = document.querySelector('.close-btn');
    closeButton.addEventListener('click', function () {
        overlay.style.display = 'none';
        overlayBg.style.display = 'none';
    });
}
//work here
function popUpEditItem(event) {
    event.preventDefault();

    var addButton = document.getElementById('add-btn');
    var overlay = document.querySelector('.overlay');
    var overlayBg = document.querySelector('.overlay-bg');

    addButton.addEventListener('click', function () {
        overlay.style.display = 'flex';
        overlayBg.style.display = 'flex';
    });
    const title = document.getElementById("title").value;
    const price = document.getElementById("price").value;
    const description = document.querySelector("textarea").value;

    // close the pop-up window
    var closeButton = document.querySelector('.close-btn');
    closeButton.addEventListener('click', function () {
        overlay.style.display = 'none';
        overlayBg.style.display = 'none';
    });
}

function showTab(tabId) {
    //debugger;
    // Hide all tabs headers and contents and reset content tab
    const newMenuList = document.getElementById('newmenulist');
    newMenuList.innerHTML = '';
    const tabContents = document.querySelectorAll('.tab-content');
    const tabHeaders = document.querySelectorAll('.tab-head');
    tabContents.forEach(tabContent => {
        tabContent.classList.remove('active');
    });
    tabHeaders.forEach(tabHeader => {
        tabHeader.classList.remove('active');
    });

    // Show the selected tab and line under tab header
    const selectedTab = document.getElementById(tabId);
    const index = tabId.charAt(tabId.length - 1);
    const tabHeaderID = "tab-head" + index;
    const selectedTabHeader = document.getElementById(tabHeaderID);
    if (selectedTab) {
        selectedTab.classList.add('active');
        selectedTabHeader.classList.add('active');
    }
    //debugger;
    addMenuItems();
}

// Create a new li element
function addMenuItems() {
    var menuItems;

    if (/*tabId == ""*/ false) {
        //document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        var xhr = new XMLHttpRequest();

        // Define the callback function to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                //Parse JSON to array of objects
                menuItems = JSON.parse(xhr.responseText);
                // Create a new li element for each item in the menuItems array    
                menuItems.forEach((item) => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('card');

                    // Set the inner HTML for the li element
                    listItem.innerHTML = `
                        <input type="hidden" class="item-id" value="${item.menu_item_id}">
                        <img class="item-image" src="${item.picture_url}" alt="Item Picture1">
                        <div class="text">
                            <h3 class="i-title">${item.item_name}</h3>
                            <p class="i-description">Ingredients: ${item.ingredient_name}</p>
                            <h3 class="i-price">$${item.price}</h3>
                        </div>
                        <div class="buttons">
                            <div class="edit-btn">
                                <i class='far fa-edit' style='color: var(--secondary-color)'></i>
                            </div>
                            <div class="del-btn">
                                <i class="fas fa-trash-alt" style="font-size:24px"></i>
                            </div>
                        </div>`;

                    const parentContainer = document.getElementById('newmenulist');
                    parentContainer.appendChild(listItem);



                });
                //Basket badge number and color
                const cartLink = document.querySelectorAll('.submit-btn');
                const badge = document.querySelector('.custom-badge');

                let count = 0;
                for (let item of cartLink) {
                    item.addEventListener('click', function (event) {
                        const card = event.target.closest('.card');
                        if (card) {
                            // Find the .item-id element within the .card
                            const itemID = card.querySelector('.item-id');
                            if (itemID) {
                                // Retrieve the text content of the .item-id element
                                const item_id_value = itemID.value;
                                console.log(item_id_value);


                            }

                        }

                    });

                }

            }
        };

        // Open a GET request to a PHP file in the same folder
        xhr.open("GET", "../../../Backend/screens/menu/getMenuItems.php", true);

        // Send the request
        xhr.send();
    }

}


function login(isLogin) {
    if (loginBtnTxt.textContent === "Sign In") {
        loginBtnTxt.textContent = "Sign Out";
        // for (let btn of delBtns) {
        //     btn.parentElement.style.display = "inline";
        // }
        //formSection.style.display = "block";
    } else {
        loginBtnTxt.textContent = "Sign In";
        window.location.href = '../../index.html';
        // for (let btn of delBtns) {
        //     btn.parentElement.style.display = "none";
        // }
        formSection.style.display = "none";
    }
}

function delCard(event) {
    event.currentTarget.parentElement.parentElement.remove();
}

function addCard(event) {
    event.preventDefault();
    //send the data to the server
    
        const title = document.getElementById("title").value;
        const price = document.getElementById("price").value;
        const description = document.querySelector("textarea").value;
        const imageSrc = "../../assets/pictures/comingSoon.jpg"
    
        // Data to send to the server
        const data = {
            title: title,
            price: price,
            description: description,
            imageSrc: imageSrc
        };
    
        // AJAX request using fetch API
        fetch('../../../Backend/screens/menu/addItem.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Handle successful response from server
            console.log('Success:', data);
            alert('Item added successfully');
        })
        .catch(error => {
            // Handle error
            console.error('Error:', error);
            // Here you can display an error message or perform other error handling actions
        });
    
    

    // const title = document.getElementById("title").value;
    // const price = document.getElementById("price").value;
    // const description = document.querySelector("textarea").value;
    // const imageSrc = "../../assets/pictures/comingSoon.jpg"


    const listItem = document.createElement('li');
    listItem.classList.add('card');

    // Set the inner HTML for the li element
    listItem.innerHTML = `
        <img class="item-image" src="${imageSrc}" alt="Item Picture1">
        <div class="text">
            <h3 class="i-title">${title}</h3>
            <p class="i-description">${description}</p>
            <h3 class="i-price">$${price}</h3>
        </div>
        <div class="buttons">
            <div class="edit-btn">
                <i class='far fa-edit' style='color: var(--secondary-color)'></i>
            </div>
            <div class="del-btn">
                <i class="fas fa-trash-alt" style="font-size:24px"></i>
            </div>
        </div>`;

    const parentContainer = document.getElementById('newmenulist');
    parentContainer.appendChild(listItem);

    const realDelBtn = document.querySelectorAll("main .card .del-btn");
    for (let btn of realDelBtn) {
            btn.addEventListener("click", delCard);
        }
    //edit events
    const allEditBtn = document.querySelectorAll("main .card .edit-btn");
    for (let btn of allEditBtn) {
            btn.addEventListener("click", editCard);
    }

    // Clear input fields
    document.getElementById("title").value = '';
    document.getElementById("price").value = '';
    document.querySelector("textarea").value = '';
}

function editCard () {
    popUpAddItem();
}

// Helper functions to avoid repetition.

function createSimpleNode(element, classes) {
    const simpleEle = document.createElement(element);
    simpleEle.className = classes;
    return simpleEle;
}

function createNodeWithText(element, content, classes) {
    const ele = createSimpleNode(element, classes);
    ele.textContent = content;
    return ele;
}

function restaurantinformation() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../../../Backend/screens/user/restaurantInformation.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            text = JSON.parse(xhr.responseText);
            document.getElementById("restaurant_name").innerText = text.restaurant_name;
            document.getElementById("website").innerText = text.website;
            document.getElementById("restaurant_phone_number").innerText = text.restaurant_phone_number;
            document.getElementById("payment_method").innerText = text.payment_method;
            card_num = text.card_number;
            // Extract the last 3 digits
            var lastThreeDigits = card_num.slice(-3);
            document.getElementById("card_number").innerText = " **** **** **** " + lastThreeDigits;
            document.getElementById("expiration_date").innerText = text.expiration_date;
            alert(text.restaurant_name);

            // Select the image element by its id
            var restaurantImage = document.getElementById("restaurant-image");
            // Change the src attribute
            restaurantImage.src = text.logo_url;

        }
    };
    xhr.send();
}