/**
 * Formatea un campo de texto con separadores de miles (punto)
 * y sincroniza el valor numérico limpio en un campo hidden.
 *
 * @param {string} inputFormattedId - ID del input visible (type="text") que el usuario edita
 * @param {string} inputRealId - ID del input hidden que almacena el valor numérico sin formato
 */
function formatMiles(inputFormattedId, inputRealId) {
    // Escucha cada cambio en el campo visible
    document.getElementById(inputFormattedId).addEventListener('input', function () {
        // Elimina todo lo que no sea dígito (letras, puntos previos, espacios, etc.)
        let raw = this.value.replace(/\D/g, '');

        // Inserta puntos como separadores de miles (ej: 1500000 → 1.500.000)
        // \B evita insertar al inicio, (?=(\d{3})+(?!\d)) busca posiciones antes de grupos de 3 dígitos
        this.value = raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        // Guarda el valor numérico limpio en el campo hidden para enviar al servidor
        document.getElementById(inputRealId).value = raw;
    });
}