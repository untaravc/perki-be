//FILTER
import moment from 'moment';
Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(value).format("DD MMM YYYY");
    }
});

Vue.filter('monthYear', function(value) {
    if (value) {
        return moment(value).format("MMM YYYY");
    }
});

Vue.filter('sortDate', function(value) {
    if (value) {
        return moment(value).format("DD MMM");
    }
});

Vue.filter('formatTime', function(value) {
    if (value) {
        return moment(value).format("DD MMM HH:mm");
    }
});

Vue.filter('formatDay', function(value) {
    if (value) {
        moment.locale('id');
        return moment(value).format("dddd, DD MMM YYYY");
    }
});

Vue.filter('formatDayTime', function(value) {
    if (value) {
        moment.locale('id');
        return moment(value).format("dddd, DD MMM YYYY HH:mm");
    }
});

Vue.filter('formatDateTime', function(value) {
    if (value) {
        let this_year = moment().year()
        if(moment(value).format("YYYY") == this_year ){
            return moment(value).format("DD MMM, HH:mm");
        }
        return moment(value).format("DD MMM YYYY, HH:mm");
    }
});

Vue.filter('currency', function(value) {
    if (value) {
        let val = (value/1).toFixed(0).replace('.', ',');
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    }
});

Vue.filter('gram', function(value) {
    if (value) {
        let val = (value/1).toFixed(0).replace('.', '.');
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }
});

Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});

Vue.filter('truncate', function(text, length, clamp){
    clamp = clamp || '...';
    var node = document.createElement('div');
    node.innerHTML = text;
    var content = node.textContent;
    return content.length > length ? content.slice(0, length) + clamp : content;
});
