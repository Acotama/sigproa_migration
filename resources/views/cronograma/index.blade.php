<!DOCTYPE html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('./plugins/gantt/codebase/dhtmlxgantt.js')}}"></script>
    <link href="{{ asset('./plugins/gantt/codebase/dhtmlxgantt.css')}}" rel="stylesheet">
    <script src="{{ asset('./plugins/gantt/codebase/locale/locale_es.js')}}" charset="utf-8"></script>
    <script src="{{ asset('./plugins/gantt/codebase/ext/dhtmlxgantt_grouping.js')}}"></script>
    <script src="{{ asset('./plugins/gantt/codebase/ext/dhtmlxgantt_fullscreen.js')}}"></script>
    <script src="{{ asset('./plugins/gantt/codebase/ext/dhtmlxgantt_tooltip.js')}}"></script>

    <style type="text/css">

    .btn-circle {
      width: 30px;
      height: 30px;
      text-align: center;
      padding: 6px 0;
      font-size: 12px;
      line-height: 1.428571429;
      border-radius: 15px;
    }
    .btn-circle.btn-lg {
      width: 50px;
      height: 50px;
      padding: 10px 16px;
      font-size: 18px;
      line-height: 1.33;
      border-radius: 25px;
    }
    .btn-circle.btn-xl {
      width: 70px;
      height: 70px;
      padding: 10px 16px;
      font-size: 24px;
      line-height: 1.33;
      border-radius: 35px;
    }

        html, body{
            height:100%;
            padding:0px;
            margin:0px;
            overflow: hidden;
        }

        .weekend{
            background: #F0DFE5 !important;
        }

        .baseline {
    			position: absolute;
    			border-radius: 2px;
    			opacity: 0.6;
    			margin-top: -7px;
    			height: 12px;
    			background: #ffd180;
    			border: 1px solid rgb(255, 153, 0);
    		}

    		/* move task lines upper */
    		.gantt_task_line, .gantt_line_wrapper {
    			margin-top: -9px;
    		}

        .gantt_side_content {
    			margin-bottom: 7px;
    		}

    		.gantt_task_link .gantt_link_arrow {
    			margin-top: -12px
    		}

    		.gantt_side_content.gantt_right {
    			bottom: 0;
    		}

        .btn-menu-item{
          display: inline-block;
          margin: 0px;
          height: 100%;
          background-color: #fff;
          border: 1px solid #cecece;
          border-bottom: none;
          border-right: none;
        }

        .btn-menu-item:hover{
          background-color: #dcdcdc;
        }


    </style>
</head>
<body>

  <!-- Modal -->
    <div class="modal fade" id="selectMeta" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title text-center">Seleccione Meta</h4>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="col-md-12">
                <table class="table table-bordered">
                  @foreach($obras as $o)
                    <tr>
                    <?php switch ($o->tipo) {
                      case 'E':
                        echo '<td><label class="label label-success">Ejecución Integral</label></td><td class="text-center"><button  onclick="selectMeta('.$o->id.')" class="btn btn-primary"><i class="glyphicon glyphicon-calendar"></i></button></td>';
                        break;
                      case 'S':
                        echo '<td><label class="label label-warning">Saldo de Obra</label> ' . $o->nom_meta . '</td><td class="text-center"><button  onclick="selectMeta('.$o->id.')" class="btn btn-warning"><i class="glyphicon glyphicon-calendar"></i></button></td>';
                        break;
                      case 'M':
                        echo '<td><label class="label label-warning">Meta</label> ' . $o->nom_meta . '</label></td><td class="text-center"><button  onclick="selectMeta('.$o->id.')" class="btn btn-success"><i class="glyphicon glyphicon-calendar"></i></button></td>';
                        break;
                    }
                    ?>
                  </tr>
                  @endforeach
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <div style="width:100%; height:15%;">
      <div style="width:100%; height: 75%;">

      </div>
      <div style="width:100%; height:25%;">
        <button type="button" data-toggle="modal" data-target="#selectMeta" class="btn-menu-item">
          <i class="glyphicon glyphicon-menu-hamburger"></i> Meta
        </button>
        <button onclick="gantt.expandAll()" class="btn-menu-item">
          <i class="glyphicon glyphicon-plus"></i> Expandir todo
        </button>
        <button onclick="gantt.collapseAll()" class="btn-menu-item">
          <i class="glyphicon glyphicon-minus"></i> Contraer todo
        </button>
        <button onclick="gantt.collapseAll()" class="btn-menu-item">
          <i class="glyphicon glyphicon-zoom-in"></i> Acercar
        </button>
        <button onclick="gantt.collapseAll()" class="btn-menu-item">
          <i class="glyphicon glyphicon-zoom-out"></i> Alejar
        </button>
        <button onclick="gantt.collapseAll()" class="btn-menu-item">
          <i class="glyphicon glyphicon-search"></i> Alinear
        </button>
        <button onclick="gantt.fullscreen()" class="btn-menu-item">
          <i class="glyphicon glyphicon-fullscreen"></i> Pantalla completa
        </button>
      </div>
    </div>

    <div id="gantt" style='width:100%; height:85%'></div>


<script type="text/javascript">

    $("#selectMeta").modal({
      backdrop: 'static',
      keyboard: false
    })

  $('#selectMeta').modal('show');


  gantt.config.xml_date = "%Y-%m-%d %H:%i:%s";
  gantt.config.order_branch = true;
  gantt.config.order_branch_free = true;
  gantt.config.task_height = 16;
  gantt.config.row_height = 40;
  gantt.locale.labels.baseline_enable_button = 'Establecer';
  gantt.locale.labels.baseline_disable_button = 'Quitar';

  // WORK time
  gantt.config.work_time = true;
  //makes all Fridays day-offs
  gantt.setWorkTime({ day:6, hours:false });
  gantt.setWorkTime({ day:7, hours:false });
  // #end Work time

  var daysStyle = function(date){
      var dateToStr = gantt.date.date_to_str("%D");
      if (dateToStr(date) == "Dom"||dateToStr(date) == "Sáb")  return "weekend";

      return "";
  };

  gantt.config.subscales = [
      {unit:"week", step :1 , date:"%W" },
      {unit:"day", step :1 , date:"%D", css:daysStyle }
  ];

  // SCALE
  gantt.config.scale_unit = "month";
  gantt.config.date_scale = "%F, %Y";

  // #end SCALE

  // INLINE EDITING
  /*var textEditor = {type: "text", map_to: "text"};
  var dateIniEditor = {type: "date", map_to: "start_date", min: new Date(2016, 0, 1), max: new Date(2030, 0, 1)};
  var dateFinEditor = {type: "date", map_to: "end_date", min: new Date(2016, 0, 1), max: new Date(2030, 0, 1)};
  var durationEditor = {type: "number", map_to: "duration", min:0, max: 100};
  var progressEditor = {type: "number", map_to: "progress", min:0, max: 100,};*/
  // #end INLINE EDITING

  // COLUMNS
  gantt.config.columns = [
    {name: "text", tree: true, width: 200, resize: true, min_width:200},
    {name: "start_date", align: "center", resize: true, min_width:90},
    //{name: "end_date", align: "center", label: 'Fin', resize: true, min_width:90},
    //{name: "progress", align: "center", label: 'Progreso', resize: true, template:function(obj){return Math.round(obj.progress*100)+"%";} },
    {name: "duration", align: "center", label:'Duración'},
    {name: "add", width: 44}
  ];
  // #end COLUMNS

  var optsPriority = [
    { key: 0, label: 'Baja'},
    { key: 1, label: 'Medio'},
    { key: 2, label: 'Alto'}
  ];
  // LIGHTBOX DEFINITION

  // ** TASK
  gantt.config.lightbox.sections= [
    {name:"description", height:30, map_to:"text", type:"textarea", focus:true},
    {name: "type", type: "typeselect", map_to: "type"},
    {
			name: "baseline",
			map_to: {
        start_date: "planned_start",
        end_date: "planned_end"
      },
			button: true,
			type: "duration_optional",
      height:30
		},
    {name:"holders",    height:42, type:"textarea", map_to:"holder", label: 'Responsable'},
    {name:"progress", height:30, map_to:"progress", type:"textarea", label: 'Progreso'},
    {name:"areaorigen",  height:30, type:"textarea", label: 'Área Origen'},
    {name:"areadestino", height:30, type:"textarea", label: 'Área Destino'},
    {name:"time",        height:72, map_to:"auto", type:"duration"}
  ];

  // ** VALORIZACIÓN
  gantt.config.lightbox.sections_project= [
    {name:"description", height:20, map_to:"text", type:"textarea", focus:true, label:'Nombre'},
    {name: "type", type: "typeselect", map_to: "type"},
    {
			name: "baseline",
			map_to: {
        start_date: "planned_start",
        end_date: "planned_end"
      },
			button: true,
			type: "duration_optional",
      height:72
		},
    {name:"holders",    height:22, type:"textarea", map_to:"holder", label: 'Responsable'},
    {name:"progress", height:52, map_to:"progress", type:"textarea", label: 'Progreso'},
    {name:"areaorigen",  height:52, type:"textarea", label: 'Área Origen'},
    {name:"areadestino", height:52, type:"textarea", label: 'Área Destino'},
    {name:"monto", height:52, type:"textarea", label: 'Monto'},
    {name:"time",        height:72, map_to:"auto", type:"duration"}

  ];

  gantt.locale.labels.section_description = "Nombre de Tarea";
  gantt.locale.labels.section_time = "Fecha Real";
  gantt.locale.labels.section_areaorigen = "Área Origen";
  gantt.locale.labels.section_areadestino = "Área Destino";
  gantt.locale.labels.section_progress = "Progreso";
  gantt.locale.labels.section_baseline = "Planificada";
  gantt.locale.labels.section_holders = "Responsables";

  gantt.locale.labels.type_project = "Valorización";

  // #end LIGHTBOX DEFINITION

  // adding baseline display
	gantt.addTaskLayer(function draw_planned(task) {
		if (task.planned_start && task.planned_end) {
			var sizes = gantt.getTaskPosition(task, task.planned_start, task.planned_end);
			var el = document.createElement('div');
			el.className = 'baseline';
			el.style.left = sizes.left + 'px';
			el.style.width = sizes.width + 'px';
			el.style.top = sizes.top + gantt.config.task_height + 13 + 'px';
			return el;
		}
		return false;
	});

  gantt.templates.task_class = function (start, end, task) {
		if (task.planned_end) {
			var classes = ['has-baseline'];
			if (end.getTime() > task.planned_end.getTime()) {
				classes.push('overdue');
			}
			return classes.join(' ');
		}
	};

	gantt.templates.rightside_text = function (start, end, task) {
		if (task.planned_end) {
			if (end.getTime() > task.planned_end.getTime()) {
				var overdue = Math.ceil(Math.abs((end.getTime() - task.planned_end.getTime()) / (24 * 60 * 60 * 1000)));
				var text = "<b>: Atrasado " + overdue + " días</b>";
				return text;
			}
		}
	};


	gantt.attachEvent("onTaskLoading", function (task) {
		task.planned_start = gantt.date.parseDate(task.planned_start, "xml_date");
		task.planned_end = gantt.date.parseDate(task.planned_end, "xml_date");
		return true;
	});

  // HORIZONTAL SCROLLBAR
  gantt.config.layout = {
    css: "gantt_container",
    cols: [
     {
       width:400,
       min_width: 300,

       // adding horizontal scrollbar to the grid via the scrollX attribute
       rows:[
        {view: "grid", scrollX: "gridScroll", scrollable: true, scrollY: "scrollVer"},
        {view: "scrollbar", id: "gridScroll"}
       ]
     },
     {resizer: true, width: 1},
     {
       rows:[
        {view: "timeline", scrollX: "scrollHor", scrollY: "scrollVer"},
        {view: "scrollbar", id: "scrollHor"}
       ]
     },
     {view: "scrollbar", id: "scrollVer"}
    ]
  };
  // HORIZONTAL SCROLLBAR

  gantt.templates.task_text=function(start,end,task){
    return "<b>"+task.text+"<b>";
  };

  // TOOLTIPS
  gantt.templates.tooltip_text = function(start,end,task){
    return "<b>Tarea: </b> "+task.text+"<br/><b>Duración:</b> " + task.duration + "<br/><b>Responsable:</b> " + task.responsable;
  };
  // #end TOOLTIPS


  // MENU ACTIONS
  gantt.collapseAll = function(){
    gantt.eachTask(function(task){
      task.$open = false;
    });
    gantt.render();
  }


  gantt.expandAll = function(){
    gantt.eachTask(function(task){
      task.$open = true;
    });
    gantt.render();
  }

  gantt.fullscreen = function(){
    if (!gantt.getState().fullscreen) {
        // expanding the gantt to full screen
        gantt.expand();
    }
    else {
        // collapsing the gantt to the normal mode
        gantt.collapse();
    }
  }

  gantt.init("gantt");
  // #end MENU ACTIONS

  var dp;
  function selectMeta(idObra) {

    $('#selectMeta').modal('hide');
    var url = "/piptotalpriori/cronograma/"+{{$proyecto->id}}+'/meta/'+idObra;

    gantt.clearAll();
    gantt.load(url);

    if (dp){
      dp.destructor();
    }
    dp = new gantt.dataProcessor(url);
    dp.init(gantt);
    dp.setTransactionMode("REST");
  }

</script>
</body>

</html>
