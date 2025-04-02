document.addEventListener('DOMContentLoaded', () => {
    // Tab Functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');

            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            button.classList.add('active');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Dummy Savings Data (Replace with actual database data)
    const savingsData = [
        { type: 'Deposit', amount: 'Ksh 5000', date: '2024-03-25' },
        { type: 'Withdrawal', amount: 'Ksh 2000', date: '2024-03-26' },
        { type: 'Deposit', amount: 'Ksh 3000', date: '2024-03-27' }
    ];

    // Load Savings Data
    const savingsGrid = document.querySelector('.savings-grid');
    function loadSavings(hasUsername) {
        savingsGrid.innerHTML = ''; // Clear existing data
        if (hasUsername) {
            savingsData.forEach(saving => {
                const savingItem = document.createElement('div');
                savingItem.classList.add('savings-item');
                savingItem.innerHTML = `
                    <h3>${saving.type}</h3>
                    <p>Amount: ${saving.amount}</p>
                    <p>Date: ${saving.date}</p>
                `;
                savingsGrid.appendChild(savingItem);
            });
        } else {
            savingsGrid.innerHTML = '<p>Please enter your details to view savings records.</p>';
        }
    }

    // Settings Form Submission
    const settingsForm = document.getElementById('settings-form');
    settingsForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const newUsername = document.getElementById('new-username').value;
        const newEmail = document.getElementById('new-email').value;
        const newPassword = document.getElementById('new-password').value;

        // Replace with actual backend API call to save settings
        console.log('New settings:', { newUsername, newEmail, newPassword });

        // Update profile info
        if (newUsername) {
            document.getElementById('profile-username').textContent = newUsername;
            updateProfilePicture(newUsername); // Update profile picture and color
            loadSavings(true); // Load savings when username exists
        }
        if (newEmail) {
            document.getElementById('profile-email').textContent = newEmail;
        }

        // Add activity log entry
        if (newUsername || newEmail || newPassword) {
            addActivity('Updated profile settings.');
        }

        // Clear form fields
        document.getElementById('new-username').value = '';
        document.getElementById('new-email').value = '';
        document.getElementById('new-password').value = '';

        alert('Settings saved successfully!');
    });

    // Function to add activity log entry
    function addActivity(message) {
        const activityLog = document.querySelector('.activity-log');
        const activityItem = document.createElement('li');
        activityItem.textContent = message;
        activityLog.appendChild(activityItem);
    }

    // Gender Detection Lists
    const femaleNames = ['Alice', 'Emma', 'Olivia', 'Sophia', 'Isabella', 'Lesley', 'Grace', 'Purity', 'Mary', 'Ava'];
    const maleNames = ['Liam', 'Noah', 'William', 'James', 'Oliver', 'Benjamin', 'Elijah', 'Lucas', 'Mason', 'Logan'];

    // Function to update profile picture and username color based on gender
    function updateProfilePicture(username) {
        const profileAvatar = document.querySelector('.profile-avatar img');
        const profileUsername = document.getElementById('profile-username');
        const firstName = username.split(' ')[0]; // Get first name
        const normalizedFirstName = firstName.toLowerCase();

        if (femaleNames.map(name => name.toLowerCase()).includes(normalizedFirstName)) {
            profileAvatar.src = 'https://i.pinimg.com/originals/da/51/c2/da51c26fe3398b0f8314fee17a98e0e7.jpg'; // Female avatar
            profileUsername.style.color = 'pink';
        } else if (maleNames.map(name => name.toLowerCase()).includes(normalizedFirstName)) {
            profileAvatar.src = 'https://thumbs.dreamstime.com/b/man-profile-cartoon-smiling-round-icon-vector-illustration-graphic-design-135443422.jpg'; // Male avatar
            profileUsername.style.color = 'blue';
        } else {
            profileAvatar.src = 'https://thumbs.dreamstime.com/b/man-profile-cartoon-smiling-round-icon-vector-illustration-graphic-design-135443422.jpg';
            profileUsername.style.color = 'blue'; // Default color
        }
    }

    // Initial profile picture and color update
    updateProfilePicture(document.getElementById('profile-username').textContent);

    // Initial savings check
    loadSavings(document.getElementById('profile-username').textContent !== 'username');
});
