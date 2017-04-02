new autoComplete({
    selector: 'input[name="q"]',
    delay: 0,
    cache: false,
    source: function(term, response){
        $.getJSON('/news/search', { q: term }, function(data){ response(data); });
    },
    renderItem: function (item, search){
        return '<div class="autocomplete-suggestion" data-val="' + item.name + '"  data-uid="' + item.id + '">' + item.name + '</div>';
    },
    onSelect: function(event, term, item) {
        window.location.replace("/tag?id="+ jQuery(item).data('uid'));
    }
});