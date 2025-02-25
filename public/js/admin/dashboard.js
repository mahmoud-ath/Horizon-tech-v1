

// Dashboard Section
/**
 * Updates the statistics on the dashboard by setting the text content
 * of each statistic element to its corresponding value from the state.
 */
function updateStatistics() {
  Object.entries(state.statistics).forEach(([key, value]) => {
      const element = elements.statsElements[key];
      if (element) {
          element.textContent = value.toLocaleString();
      }
  });
}
