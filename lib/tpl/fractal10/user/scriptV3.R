# V3

library(igraph)
library(magrittr)
library(visNetwork)
library(data.table)

#mydata <- read.csv('/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/datat.csv', head = T)
mydata <- read.csv('/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/links.csv', head = T)
nodesOrigin <- data.frame(read.csv(file = '/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/nodes.csv'))
move = names(mydata)[names(mydata) == "from" | names(mydata)== "to"]
setcolorder(mydata, c(move, setdiff(names(mydata), move)))

mydata<-mydata[!(mydata$from=="" | mydata$to==""),]

#move = names(mydata)[names(mydata) == "originator" | names(mydata)== "beneficiary"]
#setcolorder(mydata, c(move, setdiff(names(mydata), move)))

graph <- graph.data.frame(mydata, directed=T)
graphF <- graph.data.frame(mydata, directed=F)
#graph <- simplify(graph)

#graph <- simplify(graph)
#print_all(graph)

fc <- fastgreedy.community(graphF) # seems not to accept directed graph
V(graph)$community <- fc$membership
nodes <- data.frame(id = V(graph)$name, title = V(graph)$name, group = V(graph)$community)
nodes <- nodes[order(nodes$id, decreasing = F),]
edges <- get.data.frame(graph, what="edges")[1:2]


degree_value <- degree(graph, mode = "total")
nodes$value <- degree_value[match(nodes$id, names(degree_value))]
nodes[is.na(nodes)] <- 0
nodes$pageId <- nodesOrigin$pageId[match(nodes$id, nodesOrigin$id)]
nodes <- na.omit(nodes) # remove the exclude pages that have no pageid
nodes$shadow <- TRUE # Nodes will drop shadow
edges$arrows <- "to" # arrows: 'from', 'to', or 'middle'

network <- visNetwork(nodes, edges) %>%
  #visOptions(highlightNearest = TRUE, nodesIdSelection = TRUE)%>%
      visPhysics(solver = "forceAtlas2Based", forceAtlas2Based = list(gravitationalConstant = -30))%>%
      #visNodes(size = 30, color = list(highlight = list(background = "#7ea7de", border = "#2B7CE9")))%>%
      visNodes(size = 30)%>%
      visOptions(highlightNearest = TRUE,
                 nodesIdSelection = list(selected = "anchorNode"))%>%
      visLayout(randomSeed = 123)%>%
      visInteraction(dragNodes = T, dragView = FALSE, zoomView = FALSE)%>%
      visEvents(selectNode =
          "function(params) {
            var nodeID = params.nodes[0];
            var url = this.body.nodes[nodeID].options.pageId;
            location.href = url;
           }")


  visSave(network, file = "/Users/Lancelot/Sites/GitHub/fractaldhamma/lib/tpl/fractal10/user/network.html", selfcontained = F)
