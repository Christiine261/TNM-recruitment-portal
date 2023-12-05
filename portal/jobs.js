// jobs.js

document.addEventListener('DOMContentLoaded', function () {
    // Function to handle job details using AJAX
    function showJobDetails(jobId) {
      const xhr = new XMLHttpRequest();
  
      // Replace this with your actual URL
      const url = `job_details.php?id=${jobId}`;
  
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
  
            if (data.error) {
              console.error(data.error);
              // Handle error, show a message, or perform other actions
            } else {
              // Populate job details content
              const jobDetailsContent = document.getElementById('job-details-content');
              jobDetailsContent.innerHTML = `<h2>${data.job_title}</h2>
                                            <p><strong>Description:</strong><br> ${data.job_description}</p>
                                            <p><strong>Qualifications:</strong><br> ${data.qualifications}</p>
                                            <p><strong>Responsibilities:</strong><br> ${data.responsibilities}</p>
                                            <p><strong>Deadline:</strong> ${data.deadline_date}</p>`;
  
              // Show the job details section
              const jobDetailsSection = document.getElementById('job-details');
              jobDetailsSection.classList.remove('hidden');
            }
          } else {
            console.error('Error fetching job details. Status:', xhr.status);
            // Handle error, show a message, or perform other actions
          }
        }
        const allJobs = document.getElementById('all-jobs');
        allJobs.classList.toggle('collapsed', true);

        const jobDetails = document.getElementById('job-details');
        jobDetails.classList.toggle('expanded', true);
      };
  
      // Open the request
      xhr.open('GET', url, true);
  
      // Send the request
      xhr.send();
    }
  
    // Event listener for clicking on a job post
    document.querySelectorAll('.job-post').forEach(jobPost => {
      jobPost.addEventListener('click', function () {
        const jobId = this.getAttribute('data-job-id');
        showJobDetails(jobId);
      });
    });

    const closeButton = document.getElementById('close-button');
    closeButton.addEventListener('click', function () {
      // Toggle the collapsed class back on #all-jobs
      const allJobs = document.getElementById('all-jobs');
      allJobs.classList.toggle('collapsed', false);

      // Toggle the expanded class back on #job-details
      //const jobDetails = document.getElementById('job-details');
      //jobDetails.remove();
      const jobDetails = document.getElementById('job-details');
      jobDetails.classList.remove('expanded');
    });






    // Event listener for clicking on the apply button
  const applyButton = document.getElementById('apply-button');
  applyButton.addEventListener('click', function () {
    // Show the pop-up
    const applyOptionsPopup = document.getElementById('apply-options-popup');
    const overlay = document.getElementById('overlay');
    applyOptionsPopup.style.display = 'block';
    overlay.style.display = 'block';
  });

  // Event listeners for the pop-up buttons
  const applyManuallyButton = document.getElementById('apply-manually');
  applyManuallyButton.addEventListener('click', function () {
    // Add your code here to handle the "Apply Manually" action
    // For example, you can show a form or initiate a manual application process
    const manualApplicationForm = document.getElementById('manual-application-form');
    manualApplicationForm.style.display = 'block';
  });





  const applyWithCVButton = document.getElementById('apply-with-cv');
  const usePreviousApplicationButton = document.getElementById('use-previous-application');

  applyManuallyButton.addEventListener('click', function () {
    // Implement your logic for applying manually
    // For example, redirect the user to a manual application page
    alert('Applying manually...');
    closeApplyOptionsPopup();
  });

  applyWithCVButton.addEventListener('click', function () {
    // Implement your logic for applying with CV
    // For example, open a CV upload form
    alert('Applying with CV...');
    closeApplyOptionsPopup();
  });

  usePreviousApplicationButton.addEventListener('click', function () {
    // Implement your logic for using a previous application
    // For example, load a list of previous applications
    alert('Using previous application...');
    closeApplyOptionsPopup();
  });

  // Function to close the pop-up
  function closeApplyOptionsPopup() {
    const applyOptionsPopup = document.getElementById('apply-options-popup');
    applyOptionsPopup.style.display = 'none';
  }




  const closePopupButton = document.getElementById('close-button-popup');
  closePopupButton.addEventListener('click', function () {
    // Hide the pop-up and overlay
    const applyOptionsPopup = document.getElementById('apply-options-popup');
    const overlay = document.getElementById('overlay');
    applyOptionsPopup.style.display = 'none';
    overlay.style.display = 'none';
  });

  // Event listener for clicking on the overlay to close the pop-up
  const overlay = document.getElementById('overlay');
  overlay.addEventListener('click', function () {
    // Hide the pop-up and overlay
    const applyOptionsPopup = document.getElementById('apply-options-popup');
    const overlay = document.getElementById('overlay');
    applyOptionsPopup.style.display = 'none';
    overlay.style.display = 'none';
  });





  
  });
  // Toggle the collapsed class back on #all-jobs
  //const allJobs = document.getElementById('all-jobs');
 // allJobs.classList.toggle('collapsed', false);

  // Toggle the expanded class back on #job-details
 // const jobDetails = document.getElementById('job-details');
  //jobDetails.classList.toggle('expanded', false);

