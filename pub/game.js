$.fn.game = function () {
    return this.each(function (ix) {
        new game(this, ix + 1);
    });
};

var game = function (el, ix) {
    this.setDom(el, ix || 1)
        .setCallbacks()
        .setState(game.STATE_PREVIEW)
        .setUnit(game.UNIT_X);
};

game.UNIT_X = 'x';
game.UNIT_O = 'o';

game.STATE_PREVIEW = 'preview';
game.STATE_STARTED = 'grid started';
game.STATE_LOADING = 'grid loading';
game.STATE_RUNNING = 'grid running';
game.STATE_RES_WON = 'grid res-won';
game.STATE_RES_LOST = 'grid res-lost';
game.STATE_RES_DRAW = 'grid res-draw';

game.prototype.setDom = function (el, number) {
    this.$element = $('<table id="game" class="game">\n' +
        '    <caption>\n' +
        '        <div>Tic Tac Toe #' + number + '</div>\n' +
        '        <div class="loader on"></div>\n' +
        '        <div class="hint won">You won! Congrats</div>\n' +
        '        <div class="hint lost">You lost! Sorry</div>\n' +
        '        <div class="hint draw">Draw! Lets play one more time</div>\n' +
        '        <div class="hint make">Your turn</div>\n' +
        '        <button class="btn-start">Start new game</button>\n' +
        '        <button class="btn-refresh">Refresh</button>\n' +
        '        <button class="btn-finish">Finish</button>\n' +
        '    </caption>\n' +
        '    <tbody>\n' +
        '    <tr>\n' +
        '        <td></td>\n' +
        '        <td></td>\n' +
        '        <td></td>\n' +
        '    </tr>\n' +
        '    <tr>\n' +
        '        <td></td>\n' +
        '        <td></td>\n' +
        '        <td></td>\n' +
        '    </tr>\n' +
        '    <tr>\n' +
        '        <td></td>\n' +
        '        <td></td>\n' +
        '        <td></td>\n' +
        '    </tr>\n' +
        '    </tbody>\n' +
        '</table>');

    $(el).append(this.$element);

    return this;
};

game.prototype.setCallbacks = function () {
    this.$element
        .on('click', '.btn-start', $.proxy(this.start, this))
        .on('click', 'td', $.proxy(this.mark, this))
        .on('click', '.btn-refresh', $.proxy(this.refresh, this))
        .on('click', '.btn-finish', $.proxy(this.finish, this));

    return this;
};

game.prototype.setState = function (state) {
    this.state = state;
    this.$element.removeClass().addClass(['game', state].join(' '));

    return this;
};

game.prototype.setUnit = function (playerUnit) {
    this.playerUnit = playerUnit;

    return this;
};

game.prototype.start = function (ev) {
    this.clear();
    this.setState(game.STATE_STARTED);
};

game.prototype.mark = function (ev) {
    if (game.STATE_LOADING === this.state) {
        return false;
    }

    if (this.isOver()) {
        return false;
    }

    $(ev.target).addClass(this.playerUnit);

    if (this.isOver()) {
        return this.showState();
    }

    this.setState(game.STATE_LOADING);

    setTimeout($.proxy(function () {
        this.makeRequest('move', 'post', {board: this.getMatrix(), player: this.playerUnit})
            .done($.proxy(function (data) {
                //@todo validate
                this.setState(game.STATE_RUNNING);
                this.$element.find('tr:eq(' + data[1] + ')').find('td:eq(' + data[0] + ')').addClass(data[2]);
                this.showState();
            }, this));
    }, this), 1);

    return true;
};

game.prototype.getMatrix = function () {
    var matrix = [];

    this.$element.find('tr').each(function (i, tr) {
        var row = [];

        $(tr).find('td').each(function (j, td) {
            var _class = $(td).attr('class');
            row.push(_class ? _class : '');
        });

        matrix.push(row);
    });

    return matrix;
};

game.prototype.refresh = function (ev) {
    this.clear();
    this.start(ev);
};

game.prototype.finish = function (ev) {
    this.clear();
    this.setState(game.STATE_PREVIEW);
};

game.prototype.clear = function () {
    this.$element.find('td').removeClass();
};

game.prototype.makeRequest = function (action, method, data) {
    return jQuery.ajax({
        url: 'api.php?action=' + action,
        dataType: 'json',
        type: method || 'get',
        data: data || {},
        async: true
    });
};

game.prototype.isOver = function () {
    var matrix = this.getMatrix();
    var hasNoEmpty = true;

    for (var i = 0; i < 3; i++) {
        for (var j = 0; j < 3; j++) {
            if ('' == matrix[i][j]) {
                hasNoEmpty = false;
            }
        }
    }

    return hasNoEmpty || 0 != this.getWinner();
};

game.prototype.getWinner = function () {
    //analog of php Game::getWinner
    var matrix = this.getMatrix();

    var lines = [];

    lines.push(matrix[0]);
    lines.push(matrix[1]);
    lines.push(matrix[2]);
    lines.push([matrix[0][0], matrix[1][0], matrix[2][0]]);
    lines.push([matrix[0][1], matrix[1][1], matrix[2][1]]);
    lines.push([matrix[0][2], matrix[1][2], matrix[2][2]]);
    lines.push([matrix[0][0], matrix[1][1], matrix[2][2]]);
    lines.push([matrix[2][0], matrix[1][1], matrix[0][2]]);

    for (var i = 0; i < lines.length; i++) {
        if (lines[i][0] == lines[i][1] &&
            lines[i][1] == lines[i][2] &&
            lines[i][0] == game.UNIT_X) {
            return 1;
        }
        if (lines[i][0] == lines[i][1] &&
            lines[i][1] == lines[i][2] &&
            lines[i][0] == game.UNIT_O) {
            return -1;
        }
    }

    return 0;
};

game.prototype.showState = function () {
    if (this.isOver()) {
        var winner = this.getWinner();

        if (1 == winner) {
            this.setState(game.STATE_RES_WON);
        } else if (-1 == winner) {
            this.setState(game.STATE_RES_LOST);
        } else {
            this.setState(game.STATE_RES_DRAW);
        }
    } else {
        this.setState(game.STATE_RUNNING);
    }

    return true;
};