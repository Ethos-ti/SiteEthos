export function sortByString (key) {
    return function (a, b) {
        return a[key].localeCompare(b[key]);
    };
}
