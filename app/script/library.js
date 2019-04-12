function isJSON(obj) {
    let objectType = typeof obj;
    return ['boolean', 'number', 'string', 'symbol', 'function'].indexOf(objectType) === -1;
}

function convertToId(string) {
    string = string.replace(/ /g, '_');
    string = string.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    string = string.toLowerCase();
    return string;
}