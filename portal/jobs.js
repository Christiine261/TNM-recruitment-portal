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
            try{
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
            }catch{
              console.error('Error parsing JSON:', error);
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

      const applyNowButton = document.getElementById('apply-button');
      applyNowButton.addEventListener('click', function () {
          handleApplyNow(jobId);
      });
  
      // Open the request
      xhr.open('GET', url, true);
  
      // Send the request
      xhr.send();
    }

    function handleApplyNow(jobId) {
      const applyUrl = `apply_job.php?jobId=${jobId}`;
      window.location.href = applyUrl;
  }
  
    // Event listener for clicking on a job post
    document.querySelectorAll('.job-post').forEach(jobPost => {
      jobPost.addEventListener('click', function () {
        const jobId = this.getAttribute('data-job-id');
        showJobDetails(jobId);
      });
    });

/*     const closeButton = document.getElementById('close-button');
    closeButton.addEventListener('click', function () {
      // Toggle the collapsed class back on #all-jobs
      const allJobs = document.getElementById('all-jobs');
      allJobs.classList.toggle('collapsed', false);

      // Toggle the expanded class back on #job-details
      //const jobDetails = document.getElementById('job-details');
      //jobDetails.remove();
      const jobDetails = document.getElementById('job-details');
      jobDetails.classList.remove('expanded');
    }); */

});
