export default {
    meta: {
        current_page: 1,
        last_page: 1,
        searchValue: "",
        sortValue: null
    },
    status: {
      'open':'مفتوحة',
      'assigned':'مسندة',
      'not resolved':'لم تحل',
      'closed by consultant':'مغلقة من قبل المستشار',
      'closed by admin':'مغلقة من قبل المشرف',
    },
    sorts:[
        { id: "id", title: "# (تصاعدي)", icon: "fa fa-sort-numeric-up" },
        { id: "-id", title: "# (تنازلي)", icon: "fa fa-sort-numeric-down-alt" },
        {
          id: "created_at",
          title: "متى أنشئت (تصاعدي)",
          icon: "fa fa-sort-numeric-up"
        },
        {
          id: "-created_at",
          title: "متى أنشئت (تنازلي)",
          icon: "fa fa-sort-numeric-down-alt"
        }
    ],
    columns:[
        { label: "#", value: "id" },
        { label: "السؤال", value: "question.title" },
    ],
    search:{
      organizations:[],
      selectedOrganization:null,
      organizationsLoading:true,

      buildings:[],
      selectedBuilding:null,
      buildingsLoading:true,

      users:[],
      selectedUser:null,
      usersLoading:true,

      selectedStart:null,
      selectEnd:null,

      start:null,
      end:null,

      risks: [...Array(25).keys()].map(x => ++x),
      selectedRiskStart: null,
      selectedRiskEnd: null
    }
}
