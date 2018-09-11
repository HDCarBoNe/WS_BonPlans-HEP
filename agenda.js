$(document).ready(function() {
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    header:{
     left:'prev,next today',
     center:'title',
     right:'month,agendaWeek,agendaDay'
     
    },
    locale:'fr',
    events: 'load.php',
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Indiquer le thème du cours proposé");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD hh:mm");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD hh:mm");
      $.ajax({
       url:"insert.php",
       type:"POST",
       data:{title:title, start:start, end:end},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Vous avez bien ajouté un cours");
       }
      })
     }
    },
    editable:true,
    eventResize:function(event)
    {
        start=moment(start).format('YYYY/MM/DD hh:mm');
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD hh:mm");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD hh:mm");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function(){
       calendar.fullCalendar('refetchEvents');
       alert('Mise à jour du cours');
      }
     })
    },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD hh:mm");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD hh:mm");
     var title = event.title;
     var id = event.id;
     $.ajax({
      url:"update.php",
      type:"POST",
      data:{title:title, start:start, end:end, id:id},
      success:function()
      {
       calendar.fullCalendar('refetchEvents');
       alert("Mise à jour du cours");
      }
     });
    },

    eventClick:function(event)
    {
     if(confirm("Etes-vous sur de vouloir supprimer ce cours ?"))
     {
      var id = event.id;
      $.ajax({
       url:"delete.php",
       type:"POST",
       data:{id:id},
       success:function()
       {
        calendar.fullCalendar('refetchEvents');
        alert("Cours supprimé");
       }
      })
     }
    },

   });
  });