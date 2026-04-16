/**
 * Formats a text field with thousands separators (dot)
 * and syncs the clean numeric value to a hidden field.
 *
 * @param {string} inputFormattedId - ID of the visible input (type="text") the user edits
 * @param {string} inputRealId - ID of the hidden input that stores the unformatted numeric value
 */
function formatMiles(inputFormattedId, inputRealId) {
    // Listen for changes in the visible field
    document.getElementById(inputFormattedId).addEventListener('input', function () {
        // Strip everything that is not a digit (letters, previous dots, spaces, etc.)
        let raw = this.value.replace(/\D/g, '');

        // Insert dots as thousands separators (e.g. 1500000 → 1.500.000)
        // \B avoids inserting at the start; (?=(\d{3})+(?!\d)) finds positions before groups of 3 digits
        this.value = raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Store the clean numeric value in the hidden field to send to the server
        document.getElementById(inputRealId).value = raw;
    });
}