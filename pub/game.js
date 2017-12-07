/**
 * Created by snowgirl on 12/5/17.
 */

var game = function (el) {
    this.$element = $(el);
    this.setCallbacks();
    this.setState(game.STATE_PREVIEW);
    this.setUnit(game.UNIT_X);
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

game.prototype.setCallbacks = function () {
    this.$element
        .on('click', '.btn-start', $.proxy(this.start, this))
        .on('click', 'td', $.proxy(this.mark, this))
        .on('click', '.btn-refresh', $.proxy(this.refresh, this))
        .on('click', '.btn-finish', $.proxy(this.finish, this));
};

game.prototype.setState = function (state) {
    this.state = state;
    this.$element.removeClass().addClass(['game', state].join(' '));
};

game.prototype.setUnit = function (playerUnit) {
    this.playerUnit = playerUnit;
};

game.prototype.start = function (ev) {
    this.clear();
    this.setState(game.STATE_STARTED);
};
game.prototype.mark = function (ev) {
    if (game.STATE_LOADING == this.state) {
        return false;
    }

    $(ev.target).addClass(this.playerUnit);

    console.log(this.getMatrix());

    if (this.isOver()) {
        this.showState();
    } else {
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
    }

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
        console.log(winner);
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
};