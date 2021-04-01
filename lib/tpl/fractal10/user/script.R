# minimal examplelibrary('visNetwork')
library('visNetwork')
library(igraph)

nodes <- data.frame(read.csv(file = '/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/nodes.csv'))
links <- data.frame(read.csv(file = '/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/links.csv'))

graph <- graph.data.frame(links, directed = T)

degree_value <- degree(graph, mode = "total")
nodes$value <- degree_value[match(nodes$id, names(degree_value))]

nodes[is.na(nodes)] <- 0

nodes$shadow <- TRUE # Nodes will drop shadow
links$arrows <- "to" # arrows: 'from', 'to', or 'middle'

network <- visNetwork(nodes, links, height = "300px", width = "100%",physics=T) %>%
    visPhysics(solver = "forceAtlas2Based", forceAtlas2Based = list(gravitationalConstant = -30))%>%
    visNodes(size = 30)%>%
    visOptions(highlightNearest = TRUE,
               nodesIdSelection = list(selected = "4 Noble Truths"))%>%
    visLayout(randomSeed = 123) %>%
    visInteraction(dragNodes = T, dragView = FALSE, zoomView = FALSE)

visSave(network, file = "/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/network.html", selfcontained = F)

# 4 Noble Truths is used as an anchor and is changed via php in the website.
