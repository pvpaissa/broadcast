//Rising Stars #1
let risingStarsStages       = document.getElementById('rising-stars');
let risingStarsScoreboard   = document.getElementById('rising-stars-scoreboard');
let casters                 = document.getElementById('rising-stars-casters');

let stagesApi       = '/api/broadcast/rising/stages';
let scoreboardApi   = '/api/broadcast/rising/scoreboard';

if (risingStarsStages) {
    function sendStage() {
        $.ajax({
            type: "get",
            url: stagesApi,
            success: function (data) {
                updateStages(data);

                setTimeout(function () {
                    sendStage();
                }, 5000);
            }
        });
    }

    function updateStages(data) {
        updateHighlightMatch(data.highlight);
        updateMatches(data.event);
        updateRoundRobin(data.points);
    }

    function updateHighlightMatch(highlight) {
        if (!highlight) {
            return;
        }

        if (highlight.order <= 3) {
            $('#highlight-status').text('Current Elimination Match');
        } else if (highlight.order == 4) {
            $('#highlight-status').text('Current Group Stage Match');
        } else if (highlight.order == 5) {
            $('#highlight-status').text('Current Group Stage Match');
        } else if (highlight.order == 6) {
            $('#highlight-status').text('Current Group Stage Match');
        } else if (highlight.winner_id) {
            if (highlight.winner_id == highlight.claws_team_id) {
                let winningTeam = highlight.claws.name;
                $('#highlight-status').text('Winning Team: '+ winningTeam);
            } else {
                let winningTeam = highlight.fangs.name;
                $('#highlight-status').text('Winning Team: '+ winningTeam);
            }
        } else {
            $('#highlight-status').text('Grand Finals');
        }

        let clawsName = highlight.claws ? highlight.claws.name : defaultClaws;
        let clawsScore = highlight.claws_score ? highlight.claws_score : 0;

        let fangsName = highlight.fangs ? highlight.fangs.name : defaultFangs;
        let fangsScore = highlight.fangs_score ? highlight.fangs_score : 0;

        $('#highlight-match .claws .name').text(clawsName);
        $('#highlight-match .claws .score').text(clawsScore);

        $('#highlight-match .fangs .name').text(fangsName);
        $('#highlight-match .fangs .score').text(fangsScore);
    }

    function updateMatches(event) {
        if (!event) {
            return;
        }

        $.each(event.matches, function (key, value) {
            let matchNumber = value.order;

            if (event.active_match == value.id) {
                $('#rs-match-' + matchNumber).addClass('active');
            } else {
                $('#rs-match-' + matchNumber).removeClass('active');
            }

            if (matchNumber <= 3) {
                updateMatch(value, "Claws", "Fangs");
            } else if (matchNumber == 4) {
                updateMatch(value, "Winner of A", "Winner of B");
            } else if (matchNumber == 5) {
                updateMatch(value, "Winner of A", "Winner of C");
            } else if (matchNumber == 6) {
                updateMatch(value, "Winner of B", "Winner of C");
            } else {
                updateMatch(value, "#1 Seed from Stage 2", "#2 Seed from Stage 2");
            }
        });
    }

    function updateRoundRobin(points) {
        if (points.length < 3) {
            $('#rr-1 .team').text('Winner of A');
            $('#rr-1 .points').text(0);

            $('#rr-2 .team').text('Winner of B');
            $('#rr-2 .points').text(0);

            $('#rr-3 .team').text('Winner of C');
            $('#rr-3 .points').text(0);

            return;
        }

        $('#rr-1 .team').text(points[0].name);
        $('#rr-1 .points').text(points[0].points);

        $('#rr-2 .team').text(points[1].name);
        $('#rr-2 .points').text(points[1].points);

        $('#rr-3 .team').text(points[2].name);
        $('#rr-3 .points').text(points[2].points);
    }

    function updateMatch(match, defaultClaws, defaultFangs) {
        let matchNumber = match.order;

        let clawsName = match.claws ? match.claws.name : defaultClaws;
        let clawsScore = match.claws_score ? match.claws_score : 0;

        let fangsName = match.fangs ? match.fangs.name : defaultFangs;
        let fangsScore = match.fangs_score ? match.fangs_score : 0;

        $('#rs-match-' + matchNumber + ' .claws .name').text(clawsName);
        $('#rs-match-' + matchNumber + ' .claws .score').text(clawsScore);

        $('#rs-match-' + matchNumber + ' .fangs .name').text(fangsName);
        $('#rs-match-' + matchNumber + ' .fangs .score').text(fangsScore);
    }

    sendStage();
}

if (risingStarsScoreboard) {
    function sendScore() {
        $.ajax({
            type: "get",
            url: scoreboardApi,
            success: function (data) {
                makeScoreboardUpdate(data);

                //Send another request in 10 seconds.
                setTimeout(function () {
                    sendScore();
                }, 10000);
            }
        });
    }

    function makeScoreboardUpdate(data) {
        if (!data) {
            return;
        }

        $('#claws').text(data.match.claws.name ? data.match.claws.name : "Claws");
        $('#claws_score').text(data.match.claws_score ? data.match.claws_score : 0);

        $('#fangs').text(data.match.fangs.name ? data.match.fangs.name : "Fangs");
        $('#fangs_score').text(data.match.fangs_score ? data.match.fangs_score : 0);

        let gameNum = 1 + data.match.claws_score + data.match.fangs_score;
        $('#rising-stars-casters-match-name').text(gameNum);

        let casterText = data.casters;
        $('#rising-stars-casters').text(casterText);
    }

    //Call our score function
    sendScore();
}