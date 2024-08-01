const ctx = document.getElementById("myChart").getContext("2d");

function colorFromRaw(ctx) {
  if (ctx.type !== "data") {
    return "transparent";
  }
  const value = ctx.raw.v;
  let alpha;

  if (value <= 24.5) {
    alpha = 1 - (0.5 * (24.5 - value)) / 24.5;
    return Chart.helpers.color("red").alpha(alpha).rgbString();
  } else {
    alpha = 0.5 + (0.5 * (value - 24.5)) / (100 - 24.5);
    return Chart.helpers.color("green").alpha(alpha).rgbString();
  }
}

const config = {
  type: "treemap",
  data: {
    datasets: [
      {
        label: "My treemap dataset",
        tree: growthPercentages,
        borderColor: "black",
        borderWidth: 1,
        spacing: 0,
        backgroundColor: (ctx) => colorFromRaw(ctx),
        labels: {
          display: true,
          align: "center",
          position: "center",
          formatter: (ctx) => {
            return brands[ctx.dataIndex];
          },
        },
      },
    ],
  },
  options: {
    plugins: {
      title: {
        display: false,
      },
      legend: {
        display: false,
      },
      tooltip: {
        callbacks: {
          label: function (context) {
            const index = context.dataIndex;
            const value = context.raw.v;
            return `${brands[index]} : ${value}%`;
          },
        },
      },
    },
    onClick: function (event, elements) {
      if (elements.length > 0) {
        const element = elements[0];
        const index = element.index;
        const brand = brands[index];
        const value = growthPercentages[index];

        $("#brandName").val(brand);
        $("#salesVolume").val(value);
        $("#dataIndex").val(index);
        $("#editModal").modal("show");
      }
    },
  },
};

const myChart = new Chart(ctx, config);

document.getElementById("saveChanges").addEventListener("click", function () {
  const index = document.getElementById("dataIndex").value;
  const newValue = document.getElementById("salesVolume").value;

  $.post(
    "Data.php",
    {
      index: index,
      growthPercentages: newValue,
    },
    function (response) {
      responseJson = JSON.parse(response);
      if (responseJson.status === "success") {
        $("#editModal").modal("hide");
        location.reload();
      }
    }
  );
});
