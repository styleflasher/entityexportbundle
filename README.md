# entityexportbundle
Entity Export Bundle for eZPublish5

# example configuration for ezpublis/config/config.yml
``` yml

styleflasher_entity_export:
    groups:
        mysite:
            name: My Site
            entities:
                complaintform:
                    entity: ComplaintForm
                    locationId: 8943
                consultationschedule:
                    entity: ConsultationSchedule
                    locationId: 8946
                damageform:
                    entity: DamageForm
                    locationId: 8944
                    storageDirs:
                        document1:
                            field: document1
                            dir: "/form_uploads/"
                        document2:
                            field: document2
                            dir: "/form_uploads/"
                generalrequest:
                    entity: GeneralRequest
                    locationId: 8988
                offerinquiry:
                    entity: OfferInquiry
                    locationId: 8945
                sponsoringform:
                    entity: SponsoringForm
                    locationId: 10528
                    storageDirs:
                        document1:
                            field: document1
                            dir: "/form_uploads/"
                        document2:
                            field: document2
                            dir: "/form_uploads/"

```
