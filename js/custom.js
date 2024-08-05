const tabLinks = document.querySelectorAll('.tab-link');
const tabContent = document.querySelectorAll('.tab');

function openTab(event) {
  // Remove active class from all tab links
  tabLinks.forEach(tab => tab.classList.remove('active'));

  // Add active class to clicked tab link
  event.currentTarget.classList.add('active');

  // Get the year from the clicked tab
  const tabName = event.currentTarget.dataset.year;

  // Hide all tab content
  tabContent.forEach(tab => tab.classList.remove('active'));

  // Show the content for the clicked tab
  document.getElementById('tab-' + tabName).classList.add('active');
}

// Add event listeners to tab links
tabLinks.forEach(tab => {
  tab.addEventListener('click', openTab);
});

// Activate the first tab by default
openTab({ currentTarget: document.querySelector('.tab-link:first-child') });