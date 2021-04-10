
export default {

   data: () => ({

   }),//end data
   created(){

   },//End mounted()

   methods:{
        add_Requirement_ar()
        {
            this.CF.requirements_ar.push({ requirement: null });
        },
        del_Requirement_ar(index)
        {
            this.CF.requirements_ar.splice(index,1);
        },

        add_Requirement_en()
        {
                console.log('ssss');
                console.log(this.CF.requirements_en);
            this.CF.requirements_en.push({ requirement: null });
        },
        del_Requirement_en(index)
        {
            this.CF.requirements_en.splice(index,1);
        },

        add_new_Keyword()
        {
            this.Keywords.push({ cc: Math.random() });
        },
        del_row_keyword(index)
        {
            this.Keywords.splice(index,1);
        },

        add_Pakage_Basic_items_en()
        {
            this.CF.Pakage_Basic_items_en.push({ item: null });
        },
        del_Pakage_Basic_items_en(index)
        {
            this.CF.Pakage_Basic_items_en.splice(index,1);
        },

        add_Pakage_Basic_items_ar()
        {
            this.CF.Pakage_Basic_items_ar.push({ item: null });
        },
        del_Pakage_Basic_items_ar(index)
        {
            this.CF.Pakage_Basic_items_ar.splice(index,1);
        },


        add_Pakage_Standard_items_en()
        {
            this.CF.Pakage_Standard_items_en.push({ item: null });
        },
        del_Pakage_Standard_items_en(index)
        {
            this.CF.Pakage_Standard_items_en.splice(index,1);
        },

        add_Pakage_Standard_items_ar()
        {
            this.CF.Pakage_Standard_items_ar.push({ item: null });
        },
        del_Pakage_Standard_items_ar(index)
        {
            this.CF.Pakage_Standard_items_ar.splice(index,1);
        },


        add_Pakage_Premium_items_en()
        {
            this.CF.Pakage_Premium_items_en.push({ item: null });
        },
        del_Pakage_Premium_items_en(index)
        {
            this.CF.Pakage_Premium_items_en.splice(index,1);
        },

        add_Pakage_Premium_items_ar()
        {
            this.CF.Pakage_Premium_items_ar.push({ item: null });
        },
        del_Pakage_Premium_items_ar(index)
        {
            this.CF.Pakage_Premium_items_ar.splice(index,1);
        },

        add_Pakage_Bundle_items_en()
        {
            this.CF.Pakage_Bundle_items_en.push({ item: null });
        },
        del_Pakage_Bundle_items_en(index)
        {
            this.CF.Pakage_Bundle_items_en.splice(index,1);
        },

        add_Pakage_Bundle_items_ar()
        {
            this.CF.Pakage_Bundle_items_ar.push({ item: null });
        },
        del_Pakage_Bundle_items_ar(index)
        {
            this.CF.Pakage_Bundle_items_ar.splice(index,1);
        },


   }//End methods
};//End export const
