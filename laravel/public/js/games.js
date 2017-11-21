(function() {
	
    'use strict';

    function generateGamesRows(games) {
        var getCRSF_Token = function() {
            var element = document.querySelector('meta[name="csrf-token"]');
            return element.getAttribute("content");
        };
        var addRow = function(parentNode, CRSFToken, id, type, status, total_players, created_by, winner) {
            var newtr = document.createElement('tr');
            // Primeira célula (Type)
            newtd = document.createElement('td');
            var newlink = document.createElement('a');
            newlink.href= 'games/' + id;
            newlink.textContent =  id;
            newtd.appendChild(newlink);
            newtr.appendChild(newtd);
            var newtd = document.createElement('td');
            // Segunda célula (Type)
            newtd.textContent =  type;
            newtr.appendChild(newtd);
            
            // Segunda célula (Status)
            newtd = document.createElement('td');
            newtd.textContent =  status;
            newtr.appendChild(newtd);
            // Terceira célula (Number Of Players)
            newtd = document.createElement('td');
            newtd.textContent =  total_players;
            newtr.appendChild(newtd);
            // Quarta célula (Created By)
            newtd = document.createElement('td');
            newtd.textContent =  created_by;
            newtr.appendChild(newtd);
            // Quinta célula (Winner)
            newtd = document.createElement('td');
            newtd.textContent =  winner;
            newtr.appendChild(newtd);
            // Quinta Célula (1 link - edit  - e um formulário para delete)
            // Link:
           // newtd = document.createElement('td');       
            
            //newtd.appendChild(newNode);
            // Link:
            newtd = document.createElement('td');     
            var newNode = document.createElement('a');
            newNode.textContent = 'Join';
            newNode.classList.add('btn', 'btn-xs', 'btn-success');
            newNode.href = window.location.hostname + '/api/games/' + id + '/join';  
            var newNode2 = document.createElement('a');
            newNode2.textContent = 'Edit';
            newNode2.classList.add('btn', 'btn-xs', 'btn-primary');
            newNode2.href = window.location.hostname + '/games/' + id + '/edit';
            newtd.appendChild(newNode);
            newtd.appendChild(newNode2);
            // Form
            var formNode = document.createElement('form');
            formNode.action = '/api/games/'+id;
            //formNode.action = 'http://' + window.location.hostname + '/games/' + id;
            formNode.method = 'post';
            formNode.classList.add('inline');
            newNode = document.createElement('input');
            newNode.type = 'hidden';
            newNode.name = '_method';
            newNode.value = 'DELETE';
            formNode.appendChild(newNode);
            newNode = document.createElement('input');
            newNode.type = 'hidden';
            newNode.name = '_token';
            newNode.value = CRSFToken;
            formNode.appendChild(newNode);
            var divNode = document.createElement('div');
            divNode.classList.add('form-group');
            newNode = document.createElement('button');
            newNode.type = 'submit';
            newNode.textContent = 'Delete';
            newNode.classList.add('btn', 'btn-xs', 'btn-danger');
            divNode.appendChild(newNode);
            formNode.appendChild(divNode);
            newtd.appendChild(formNode);
            newtr.appendChild(newtd);
            parentNode.appendChild(newtr);      
        };

        var tbodyElement = document.getElementsByTagName('tbody')[0];
        var CRSFToken = getCRSF_Token();
        games.forEach(function(game) {
            addRow(tbodyElement, CRSFToken, game.id, game.type, game.status, game.total_players, game.created_by, game.winner);
            });

    }


    var getPage = function(event) {
        var url = '/api/games';
        if(event) {
            event.preventDefault();
            url = $(event.target).attr('data-url');
            if (url == 'null') return;
        }
        axios.get(url).then(function(result) {
            //console.log(data);
            $('tbody').html('');
            generateGamesRows(result.data);
            var $pagination = $('.pagination');
            $pagination.html('');
            $pagination.append('<li class="page-item"><a class="page-link" data-url="'+result.data.prev_page_url+'">Previous</a></li>');
            for(var i = 1; i <= result.data.last_page; i++) {
                $pagination.append('<li class="page-item"><a class="page-link" data-url="'+result.data.path+'/?page='+i+'">'+i+'</a></li>');
            }
            $pagination.append('<li class="page-item"><a class="page-link" data-url="'+result.data.next_page_url+'">Next</a></li>');

            $('.page-link').click(getPage);
        }).catch(console.log);
    };

    getPage();
	

})();