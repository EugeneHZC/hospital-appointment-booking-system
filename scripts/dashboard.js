$(document).ready(function () {
  let role = $("#role").val();
  let chart = null;

  if (role == "admin") {
    // if user is an admin
    $("#department").change(function () {
      let department = $("#department").val();
      let doctor = $("#doctor").val();

      if (chart) {
        chart.destroy();
      }

      let chartContext = document.getElementById("chart");

      if (department == "") {
        chart = new Chart(chartContext, {
          type: "bar",
          data: {
            labels: [
              "Heart Specialist Department",
              "Dental Treatment Department",
              "Children Healthcare Department",
            ],
            datasets: [
              {
                label: "Dr. Ahmad",
                data: [4],
                borderWidth: 1,
              },
              {
                label: "Dr. Sarah",
                data: [20, 6, 7],
                borderWidth: 1,
              },
              {
                label: "Dr. Ali",
                data: [11, 13, 21],
                borderWidth: 1,
              },
            ],
          },
          options: {
            scales: {
              y: { beginAtZero: true },
            },
          },
        });
      } else {
        chart = new Chart(chartContext, {
          type: "bar",
          data: {
            labels: ["Dr. Ahmad", "Dr. Sarah", "Dr. Ali"],
            datasets: [
              {
                label: "Scheduled",
                data: [10, 13, 20],
                borderWidth: 1,
              },
              {
                label: "Completed",
                data: [12, 5, 10],
                borderWidth: 1,
              },
              {
                label: "Cancelled",
                data: [8, 7, 3],
                borderWidth: 1,
              },
            ],
          },
          options: {
            scales: {
              y: { beginAtZero: true },
            },
          },
        });
      }
    });
  } else {
    // if user is a doctor
    $("#start-date, #end-date").change(function () {
      let startDate = $("#start-date").val();
      let endDate = $("#end-date").val();

      if (!startDate || !endDate) {
        return;
      }

      if (startDate > endDate) {
        $("#end-date").val(startDate);
      }

      if (chart) {
        chart.destroy();
      }

      let chartContext = document.getElementById("chart");

      chart = new Chart(chartContext, {
        type: "bar",
        data: {
          labels: ["30/5/2026", "31/5/2026", "1/6/2026", "2/6/2026"],
          datasets: [
            {
              label: "Scheduled",
              data: [10, 13, 20, 11],
              borderWidth: 1,
            },
            {
              label: "Completed",
              data: [12, 5, 10, 15],
              borderWidth: 1,
            },
            {
              label: "Cancelled",
              data: [8, 7, 3, 20],
              borderWidth: 1,
            },
          ],
        },
        options: {
          scales: {
            y: { beginAtZero: true },
          },
        },
      });
    });
  }
});
