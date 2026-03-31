# Ticket API extension points

This resource is intentionally lightweight and can be extended by custom providers implementing:

- `TicketApiResourceConfigProviderInterface`
- `TicketImportExportConfigProviderInterface`
- `TicketAsyncNotificationPublisherInterface`

It keeps Oro core bundles untouched while allowing project-level integrations.
