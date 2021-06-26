function autocomplete(dataArray, options) {
    var configDefault = {
        searchContainer: document.querySelector('.js-search-container'),
        searchInput: document.querySelector('.js-search'),
        suggestions: document.querySelector('.js-suggestions'),
        customEventName: 'autocomplete',
    };
    var config = {};
    var suggestionListIndex = 0;

    function parseOptions() {
        options = options || {};
        Object.assign(config, _.extend(configDefault, options));
    }

    function findMatches(wordToMatch, dataArray) {
        return dataArray.filter(function(data) {
            var regex = new RegExp(wordToMatch, 'gi');
            return data.match(regex)
        });
    }

    function displayMatches(e) {
        var isArrowDownOrUpPressed = (e.keyCode === 40 || e.keyCode === 38);
        var inputValue = e.target.value;

        if (config.searchInput.value.length > 1 && !isArrowDownOrUpPressed) {
            var matchArray = findMatches(this.value, dataArray);

            var html = matchArray.map(function(post) {
                var regex = new RegExp(inputValue, 'gi');
                var matchedValue = post.match(regex)[0];
                var postName = post.replace(regex, '<strong>' + matchedValue + '</strong>');

                return '<li class="js-autocomplete-suggestion v7-autocomplete-element">' + postName + '</li>';
            }).join('');

            if (html.length) {
                config.suggestions.innerHTML = html;
                config.suggestions.classList.remove('is-hidden');
                autoFillSuggestion();
            } else {
                hideSuggestions();
            }
        } else if (!isArrowDownOrUpPressed) {
            hideSuggestions();
        }
    }

    function browseSuggestions(e) {
        var keyCode = e.keyCode;
        var suggestionList = document.querySelectorAll('.js-autocomplete-suggestion');
        var suggestionSelection = suggestionList[suggestionListIndex];
        var suggestionListMaxIndex = suggestionList.length - 1;

        // arrow down
        if (keyCode === 40) {
            removeAllSuggestionsHighlight(suggestionList);

            config.searchInput.value = suggestionSelection.textContent.trim();
            suggestionSelection.classList.add('is-selected');

            if (suggestionListIndex >= suggestionListMaxIndex) {
                suggestionListIndex = 0;
            } else {
                suggestionListIndex++;
            }
        // arrow up
        } else if (keyCode === 38) {
            removeAllSuggestionsHighlight(suggestionList);

            if (suggestionListIndex === 0) {
                suggestionListIndex = suggestionListMaxIndex;
            } else {
                suggestionListIndex--;
            }

            config.searchInput.value = suggestionSelection.textContent.trim();
            suggestionSelection.classList.add('is-selected');
        }
    }

    function removeAllSuggestionsHighlight(suggestions) {
        suggestions.forEach(function(suggestion) {
            suggestion.classList.remove('is-selected')
        })
    }

    function autoFillSuggestion() {
        var suggestionList = document.querySelectorAll('.js-autocomplete-suggestion');

        suggestionList.forEach(function(element) {
            element.addEventListener('click', function() {
                config.searchInput.value = this.textContent.trim();
                var event = new Event(config.customEventName);
                config.searchInput.dispatchEvent(event);
            })
        });
    }

    function hideSuggestions() {
        config.suggestions.innerHTML = '';
        config.suggestions.classList.add('is-hidden');
    }

    function hideSuggestionsOnClick(e) {
        if (e.target !== config.searchContainer) {
            hideSuggestions();
        }
    }

    function bindEventListeners() {
        if (config.searchInput) {
            config.searchInput.addEventListener('keyup', displayMatches);
            config.searchInput.addEventListener('keyup', browseSuggestions);
            window.addEventListener('click', hideSuggestionsOnClick);
        }
    }


    function init() {
        parseOptions();
        bindEventListeners();
    }

    window.addEventListener('load', init);
}
