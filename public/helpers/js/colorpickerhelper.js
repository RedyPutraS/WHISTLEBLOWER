function setColor(colorpicker_id, target_id) {
    const colorpicker = document.getElementById(colorpicker_id);
    const target = document.getElementById(target_id);

    target.value = colorpicker.value;
}